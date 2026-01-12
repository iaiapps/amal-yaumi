<?php

namespace App\Http\Controllers;

use App\Models\MutabaahItem;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MutabaahItemController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        
        if ($role == 'admin') {
            // Admin can see all items grouped by teacher
            $items = MutabaahItem::with('teacher')->orderBy('teacher_id')->orderBy('urutan')->get();
        } else {
            // Guru only sees their own items
            $teacher = $user->teacher;
            $items = MutabaahItem::where('teacher_id', $teacher->id)->orderBy('urutan')->get();
        }

        return view('mutabaah-item.index', compact('items', 'role'));
    }

    public function create()
    {
        return view('mutabaah-item.create');
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $teacher = $user->teacher;

        if (!$teacher) {
            return redirect()->back()->with('error', 'Hanya Guru yang dapat mengelola item mutabaah.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:sholat_wajib,sholat_sunnah,lainnya',
            'tipe' => 'required|in:ya_tidak,angka,text',
            'urutan' => 'required|integer',
        ]);

        $data = $request->all();
        $data['teacher_id'] = $teacher->id;

        MutabaahItem::create($data);

        return redirect()->route('mutabaah-item.index')->with('success', 'Item berhasil ditambahkan');
    }

    public function edit(MutabaahItem $mutabaahItem)
    {
        return view('mutabaah-item.edit', compact('mutabaahItem'));
    }

    public function update(Request $request, MutabaahItem $mutabaahItem)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:sholat_wajib,sholat_sunnah,lainnya',
            'tipe' => 'required|in:ya_tidak,angka,text',
            'urutan' => 'required|integer',
        ]);

        $mutabaahItem->update($request->all());

        return redirect()->route('mutabaah-item.index')->with('success', 'Item berhasil diperbarui');
    }

    public function destroy(MutabaahItem $mutabaahItem)
    {
        $mutabaahItem->delete();
        return redirect()->route('mutabaah-item.index')->with('success', 'Item berhasil dihapus');
    }

    public function toggle(MutabaahItem $mutabaahItem)
    {
        $mutabaahItem->update(['is_active' => !$mutabaahItem->is_active]);
        return redirect()->back()->with('success', 'Status berhasil diubah');
    }
}
