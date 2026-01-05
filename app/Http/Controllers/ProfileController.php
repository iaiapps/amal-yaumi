<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        return view('profile.edit', compact('user', 'teacher'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jk' => 'nullable|in:L,P',
            'telp' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $userData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user->update($userData);

        // Update or create teacher profile
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if ($request->filled('nama')) {
            $teacherData = [
                'nama' => $request->nama,
                'nip' => $request->nip,
                'jk' => $request->jk,
                'telp' => $request->telp,
            ];

            if ($request->hasFile('photo')) {
                if ($teacher && $teacher->photo) {
                    Storage::disk('public')->delete($teacher->photo);
                }
                $teacherData['photo'] = $request->file('photo')->store('teachers', 'public');
            }

            if ($teacher) {
                $teacher->update($teacherData);
            } else {
                $teacherData['user_id'] = $user->id;
                Teacher::create($teacherData);
            }
        }

        return redirect()->route('profile.edit')->with('success', 'Profile berhasil diperbarui');
    }
}
