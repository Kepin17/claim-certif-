<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'date',
        'location',
        'is_active',
        'max_participants',
        'certificate_template',
        'poster',
        'overlay_name_top',
        'overlay_name_left',
        'overlay_name_size',
        'overlay_name_color',
        'overlay_role_top',
        'overlay_role_left',
        'overlay_role_size',
        'overlay_role_text',
        'overlay_role_color',
        'certificate_number_prefix',
        'claim_deadline',
        'requires_attendance_proof',
        'requires_payment_proof',
    ];

    protected $casts = [
        'date' => 'date',
        'claim_deadline' => 'datetime',
        'is_active' => 'boolean',
        'requires_attendance_proof' => 'boolean',
        'requires_payment_proof' => 'boolean',
    ];

    public function isClaimOpen(): bool
    {
        if (!$this->is_active) return false;
        if ($this->claim_deadline && now()->isAfter($this->claim_deadline)) return false;
        return true;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug) && !empty($event->name)) {
                $event->slug = static::generateSlug($event->name);
            }
        });

        static::updating(function ($event) {
            if ($event->isDirty('name') && !empty($event->name)) {
                $event->slug = static::generateSlug($event->name);
            }
        });
    }

    public static function generateSlug($name)
    {
        $slug = strtolower(str_replace(' ', '-', $name));
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function certificateTypes()
    {
        return $this->hasMany(CertificateType::class)->orderBy('sort_order');
    }

    public function activeCertificateTypes()
    {
        return $this->hasMany(CertificateType::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
