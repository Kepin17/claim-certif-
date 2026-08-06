<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    private ?\Google_Client $client = null;
    private ?\Google_Service_Drive $driveService = null;
    private bool $enabled;

    public function __construct()
    {
        $this->enabled = config('services.google_drive.enabled', false);
    }

    /**
     * Apakah Google Drive diaktifkan dan terkonfigurasi?
     */
    public function isEnabled(): bool
    {
        if (!$this->enabled) return false;

        $credPath = config('services.google_drive.service_account_json');
        $rootId   = config('services.google_drive.root_folder_id');

        return !empty($credPath) && !empty($rootId) && file_exists($credPath);
    }

    /**
     * Inisialisasi Google Client (lazy).
     */
    private function init(): void
    {
        if ($this->driveService) return;

        $credPath = config('services.google_drive.service_account_json');

        $this->client = new \Google_Client();
        $this->client->setAuthConfig($credPath);
        $this->client->addScope(\Google_Service_Drive::DRIVE);
        $this->client->setApplicationName('Certif System');

        $this->driveService = new \Google_Service_Drive($this->client);
    }

    /**
     * Cari folder berdasarkan nama di dalam parent folder tertentu.
     * Kembalikan ID-nya, atau null jika tidak ditemukan.
     */
    private function findFolder(string $name, string $parentId): ?string
    {
        $this->init();

        $safeName = str_replace("'", "\\'", $name);
        $query    = "name='{$safeName}' and mimeType='application/vnd.google-apps.folder'"
                  . " and '{$parentId}' in parents and trashed=false";

        $result = $this->driveService->files->listFiles([
            'q'      => $query,
            'fields' => 'files(id, name)',
        ]);

        return $result->getFiles()[0]?->getId();
    }

    /**
     * Buat folder baru di dalam parent.
     */
    private function createFolder(string $name, string $parentId): string
    {
        $this->init();

        $meta = new \Google_Service_Drive_DriveFile([
            'name'     => $name,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents'  => [$parentId],
        ]);

        $folder = $this->driveService->files->create($meta, ['fields' => 'id']);
        return $folder->getId();
    }

    /**
     * Dapatkan atau buat folder event di dalam root folder.
     * Format: RootFolder / EventName
     */
    public function getOrCreateEventFolder(string $eventName): string
    {
        $this->init();

        $rootId = config('services.google_drive.root_folder_id');

        // Bersihkan nama event untuk folder
        $folderName = trim($eventName);

        $folderId = $this->findFolder($folderName, $rootId);

        if (!$folderId) {
            Log::info('[GDrive] Creating event folder', ['name' => $folderName]);
            $folderId = $this->createFolder($folderName, $rootId);
        }

        return $folderId;
    }

    /**
     * Upload file PDF ke folder event di Google Drive.
     * Kembalikan file ID Drive, atau null jika gagal.
     */
    public function uploadCertificate(string $localPath, string $filename, string $eventName): ?string
    {
        if (!$this->isEnabled()) {
            Log::info('[GDrive] Upload skipped – Google Drive is disabled.');
            return null;
        }

        try {
            $this->init();

            $eventFolderId = $this->getOrCreateEventFolder($eventName);

            $meta = new \Google_Service_Drive_DriveFile([
                'name'    => $filename,
                'parents' => [$eventFolderId],
            ]);

            $content = file_get_contents($localPath);

            $file = $this->driveService->files->create($meta, [
                'data'       => $content,
                'mimeType'   => 'application/pdf',
                'uploadType' => 'multipart',
                'fields'     => 'id, webViewLink',
            ]);

            Log::info('[GDrive] Certificate uploaded successfully', [
                'file_id'       => $file->getId(),
                'event'         => $eventName,
                'filename'      => $filename,
            ]);

            return $file->getId();

        } catch (\Throwable $e) {
            Log::error('[GDrive] Upload failed', [
                'error'    => $e->getMessage(),
                'filename' => $filename,
                'event'    => $eventName,
            ]);

            // Jangan lempar exception — biarkan proses utama tetap jalan
            return null;
        }
    }

    /**
     * Buat shareable view link dari file ID.
     */
    public static function makeViewLink(string $fileId): string
    {
        return 'https://drive.google.com/file/d/' . $fileId . '/view';
    }
}
