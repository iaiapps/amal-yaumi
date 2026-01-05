<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classrooms';
    protected $guarded = ['id'];

    public function students()
    {
        return $this->hasMany(Student::class, 'kelas', 'nama');
    }
}
