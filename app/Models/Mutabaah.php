<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutabaah extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
        'tanggal' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
