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

    /**
     * Generate a unique teacher code for students to login
     * Using salt and multiplier to obscure the actual ID
     */
    public function getTeacherCode()
    {
        $obfuscatedId = ($this->id + 1234) * 3;
        return 'AY-' . strtoupper(base_convert($obfuscatedId, 10, 36));
    }

    /**
     * Decode teacher code back to teacher ID
     */
    public static function decodeTeacherCode($code)
    {
        $code = strtoupper($code);
        if (str_starts_with($code, 'AY-')) {
            $base36 = substr($code, 3);
            $obfuscatedId = base_convert($base36, 36, 10);

            // Reverse the formula: ($id + 1234) * 3
            return ($obfuscatedId / 3) - 1234;
        }
        return null;
    }
}
