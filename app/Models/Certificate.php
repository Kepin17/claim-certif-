<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'event',
        'proof_file',
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
