<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'admin_name',
        'action',
        'certificate_id',
        'certificate_name',
        'event_name',
        'notes',
    ];

    public static function record(string $action, $certificate = null, string $notes = null): void
    {
        $admin = auth()->user();
        static::create([
            'admin_id'         => $admin?->id,
            'admin_name'       => $admin?->name ?? 'System',
            'action'           => $action,
            'certificate_id'   => $certificate?->id,
            'certificate_name' => $certificate?->name,
            'event_name'       => $certificate?->event,
            'notes'            => $notes,
        ]);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class)->withTrashed();
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'admin_id');
    }

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'approved'         => 'Approved',
            'rejected'         => 'Rejected',
            'reset_to_pending' => 'Reset to Pending',
            'regenerated'      => 'Regenerated',
            'resent_email'     => 'Resent Email',
            'bulk_approved'    => 'Bulk Approved',
            'bulk_rejected'    => 'Bulk Rejected',
            default            => ucfirst(str_replace('_', ' ', $this->action)),
        };
    }

    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'approved', 'bulk_approved' => 'green',
            'rejected', 'bulk_rejected' => 'red',
            'reset_to_pending'          => 'amber',
            default                     => 'gray',
        };
    }
}
