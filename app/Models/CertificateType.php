<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateType extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'role_text',
        'certificate_number_prefix',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function getRoleDisplayText(): string
    {
        return $this->role_text ?: $this->name;
    }
}
