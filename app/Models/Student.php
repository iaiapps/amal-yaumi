<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function mutabaah()
    {
        return $this->hasMany(Mutabaah::class);
    }

    /**
     * Calculate current daily streak
     */
    public function getCurrentStreak()
    {
        $streak = 0;
        $date = \Carbon\Carbon::today();
        
        while (true) {
            $exists = $this->mutabaah()->whereDate('tanggal', $date)->exists();
            if (!$exists) break;
            $streak++;
            $date->subDay();
        }
        
        return $streak;
    }

    /**
     * Calculate longest streak recorded
     */
    public function getLongestStreak()
    {
        $mutabaahs = $this->mutabaah()->orderBy('tanggal', 'asc')->pluck('tanggal')->map(fn($date) => $date->format('Y-m-d'))->toArray();
        
        if (empty($mutabaahs)) return 0;
        
        $longestStreak = 1;
        $currentStreak = 1;
        
        for ($i = 1; $i < count($mutabaahs); $i++) {
            $prevDate = \Carbon\Carbon::parse($mutabaahs[$i - 1]);
            $currDate = \Carbon\Carbon::parse($mutabaahs[$i]);
            
            if ($prevDate->addDay()->isSameDay($currDate)) {
                $currentStreak++;
                $longestStreak = max($longestStreak, $currentStreak);
            } else {
                $currentStreak = 1;
            }
        }
        
        return $longestStreak;
    }

    /**
     * Calculate virtual badges based on consistency
     */
    public function getBadges()
    {
        $monthlyCount = $this->mutabaah()->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->count();
        $streak = $this->getCurrentStreak();
        $longestStreak = $this->getLongestStreak();
        
        $badges = [];
        
        // Intensity/Streak Badges
        if ($longestStreak >= 100)
            $badges[] = ['icon' => '👑', 'name' => 'Istiqomah Master', 'desc' => '100 hari berturut-turut'];
        elseif ($longestStreak >= 30)
            $badges[] = ['icon' => '⭐', 'name' => 'Konsisten Sebulan', 'desc' => '30 hari berturut-turut'];
        elseif ($longestStreak >= 7)
            $badges[] = ['icon' => '🔥', 'name' => 'Semangat Seminggu', 'desc' => '7 hari berturut-turut'];

        // Completion/Volume Badges
        $daysInMonth = now()->daysInMonth;
        if ($monthlyCount >= $daysInMonth)
            $badges[] = ['icon' => '💯', 'name' => 'Perfect Month', 'desc' => 'Lengkap sebulan penuh'];
        elseif ($monthlyCount >= 25)
            $badges[] = ['icon' => '🌟', 'name' => 'Rajin Banget', 'desc' => '25+ hari bulan ini'];
        elseif ($monthlyCount >= 15)
            $badges[] = ['icon' => '✨', 'name' => 'Terus Semangat', 'desc' => '15+ hari bulan ini'];
            
        return $badges;
    }
}
