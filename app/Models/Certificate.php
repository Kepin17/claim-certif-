<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'certificate_type_id',
        'certificate_type_name',
        'name',
        'email',
        'event',
        'proof_file',
        'attendance_photo',
        'payment_proof',
        'custom_email_message',
        'message',
        'next_event',
        'status',
        'certificate_number',
        'pdf_path',
        'qr_code',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'unique_key',
    ];

    /**
     * Deteksi tipe penghargaan berdasarkan nama tipe sertifikat / role.
     * Returns: 'juara1' | 'juara2' | 'juara3' | 'peserta'
     */
    public function getAwardType(): string
    {
        $typeName = strtolower($this->certificate_type_name ?? $this->certificateType?->name ?? '');

        $patterns = [
            'juara1'  => ['juara 1', 'juara1', 'juara i', 'first', '1st place', 'winner', 'gold', 'emas', 'champion'],
            'juara2'  => ['juara 2', 'juara2', 'juara ii', 'second', '2nd place', 'runner up', 'silver', 'perak'],
            'juara3'  => ['juara 3', 'juara3', 'juara iii', 'third', '3rd place', 'bronze', 'perunggu'],
        ];

        foreach ($patterns as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($typeName, $keyword)) {
                    return $type;
                }
            }
        }

        return 'peserta';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {
            if (empty($certificate->unique_key)) {
                $certificate->unique_key = self::generateUniqueKey();
            }
        });
    }

    public static function generateUniqueKey()
    {
        do {
            $key = bin2hex(random_bytes(16));
        } while (self::where('unique_key', $key)->exists());

        return $key;
    }

    public function scopeByUniqueKey($query, $key)
    {
        return $query->where('unique_key', $key);
    }

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventRelation()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function certificateType()
    {
        return $this->belongsTo(CertificateType::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeGenerated($query)
    {
        return $query->where('status', 'generated');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isGenerated()
    {
        return $this->status === 'generated';
    }
}
