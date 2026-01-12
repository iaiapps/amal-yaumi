<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function mutabaahItems()
    {
        return $this->hasMany(MutabaahItem::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, Classroom::class, 'teacher_id', 'kelas', 'id', 'nama');
    }
}
