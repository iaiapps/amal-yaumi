<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutabaahItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}
