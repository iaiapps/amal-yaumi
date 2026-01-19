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
        
        if ($user->hasRole('admin')) {
            return view('profile.edit-admin', compact('user'));
        } elseif ($user->hasRole('guru')) {
            $teacher = $user->teacher;
            return view('profile.edit-teacher', compact('user', 'teacher'));
        } else {
            $student = $user->student;
            return view('profile.edit-student', compact('user', 'student'));
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            return $this->updateAdmin($request, $user);
        } elseif ($user->hasRole('guru')) {
            return $this->updateTeacher($request, $user);
        } else {
            return $this->updateStudent($request, $user);
        }
    }
    
    private function updateAdmin(Request $request, $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $userData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user->update($userData);

        return redirect()->route('profile.edit')->with('success', 'Profile Admin berhasil diperbarui');
    }

    private function updateTeacher(Request $request, $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nip' => 'nullable|string|max:50',
            'jk' => 'nullable|in:L,P',
            'telp' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update User
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $userData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }
        $user->update($userData);

        // Update Teacher
        $teacher = $user->teacher;
        $teacherData = [
            'nama' => $user->name,
            'nip' => $request->nip,
            'jk' => $request->jk,
            'telp' => $request->telp,
        ];

        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $teacherData['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($teacherData);

        return redirect()->route('profile.edit')->with('success', 'Profile Guru berhasil diperbarui');
    }
    
    private function updateStudent(Request $request, $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $userData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user->update($userData);

        // Sync Student name if exists
        if ($user->student) {
            $user->student->update(['nama' => $user->name]);
        }

        return redirect()->route('profile.edit')->with('success', 'Profile Siswa berhasil diperbarui');
    }
    
    public function changePassword()
    {
        return view('profile.change-password');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah');
    }
}
