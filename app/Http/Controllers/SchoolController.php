<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
    public function edit()
    {
        $school = School::first();
        return view('setting.index', compact('school'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'kepala_sekolah' => 'nullable|string|max:255',
            'nip_kepala' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'max_class_per_teacher' => 'required|integer|min:1',
        ]);

        $school = School::first();
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $school->update($data);

        return redirect()->route('setting.index')->with('success', 'Pengaturan berhasil diperbarui');
    }
}
