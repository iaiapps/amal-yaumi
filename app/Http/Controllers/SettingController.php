<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_class_per_teacher' => 'required|integer|min:1',
            'max_students_per_class' => 'required|integer|min:1',
        ]);

        $setting = Setting::first();
        $setting->update($request->only(['max_class_per_teacher', 'max_students_per_class']));

        return redirect()->route('admin.setting.index')->with('success', 'Pengaturan platform berhasil diperbarui');
    }
}
