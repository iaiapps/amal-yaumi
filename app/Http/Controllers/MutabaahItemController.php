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
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);
        $role = $user->getRoleNames()->first();

        if ($role == 'admin') {
            $items = MutabaahItem::with('teacher')->orderBy('teacher_id')->orderBy('urutan')->get();
        } else {
            $teacher = $user->teacher;
            $items = MutabaahItem::where('teacher_id', $teacher->id)->orderBy('urutan')->get();
        }

        return view('guru.mutabaah-item.index', compact('items', 'role'));
    }

    public function create()
    {
        $existingCategories = MutabaahItem::pluck('kategori')->unique();
        return view('guru.mutabaah-item.create', compact('existingCategories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);
        $teacher = $user->teacher;

        if (!$teacher) {
            return redirect()->back()->with('error', 'Hanya Guru yang dapat mengelola item mutabaah.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe' => 'required|in:ya_tidak,angka,text',
            'urutan' => 'required|integer',
        ]);

        $data = $request->all();
        $data['teacher_id'] = $teacher->id;

        MutabaahItem::create($data);

        return redirect()->route('guru.mutabaah-item.index')->with('success', 'Item berhasil ditambahkan');
    }

    public function edit(MutabaahItem $mutabaah_item)
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);
        if ($user->getRoleNames()->first() == 'guru' && $mutabaah_item->teacher_id != $user->teacher->id) {
            abort(403);
        }

        $existingCategories = MutabaahItem::pluck('kategori')->unique();
        return view('guru.mutabaah-item.edit', compact('mutabaah_item', 'existingCategories'));
    }

    public function update(Request $request, MutabaahItem $mutabaah_item)
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);
        if ($user->getRoleNames()->first() == 'guru' && $mutabaah_item->teacher_id != $user->teacher->id) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe' => 'required|in:ya_tidak,angka,text',
            'urutan' => 'required|integer',
        ]);

        $mutabaah_item->update($request->all());

        return redirect()->route('guru.mutabaah-item.index')->with('success', 'Item berhasil diperbarui');
    }

    public function destroy(MutabaahItem $mutabaah_item)
    {
        $user = Auth::user();
        if (!$user instanceof User)
            abort(401);
        if ($user->getRoleNames()->first() == 'guru' && $mutabaah_item->teacher_id != $user->teacher->id) {
            abort(403);
        }

        $mutabaah_item->delete();
        return redirect()->route('guru.mutabaah-item.index')->with('success', 'Item berhasil dihapus');
    }

    public function toggle(MutabaahItem $mutabaah_item)
    {
        $mutabaah_item->update(['is_active' => !$mutabaah_item->is_active]);
        return redirect()->back()->with('success', 'Status berhasil diubah');
    }
    public function reorder()
    {
        $user = Auth::user();
        if (!$user instanceof User) abort(401);
        $teacher = $user->teacher;

        if (!$teacher) {
            return redirect()->back()->with('error', 'Hanya Guru yang dapat mengelola item mutabaah.');
        }

        $items = MutabaahItem::where('teacher_id', $teacher->id)->orderBy('urutan')->get();
        return view('guru.mutabaah-item.reorder', compact('items'));
    }

    public function updateOrder(Request $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) abort(401);
        $teacher = $user->teacher;

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|min:1',
        ]);

        foreach ($request->order as $id => $order) {
            MutabaahItem::where('id', $id)
                ->where('teacher_id', $teacher->id)
                ->update(['urutan' => $order]);
        }

        return redirect()->route('guru.mutabaah-item.index')->with('success', 'Urutan berhasil diperbarui');
    }
}
