<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var \App\Models\User */

        $user = Auth::user();
        $id = $user->id;

        // get name
        $name = $user->name;

        //get role names
        $role = $user->getRoleNames()->first();

        // get student all
        $students = Student::all();
        // student name
        $student = Student::where('user_id', '=', $id)->first();

        // now
        // $now = Carbon::now();

        $status = 'anda tidak terdaftar';

        switch ($role) {
            case 'admin':
                return view('home', compact('students', 'name'));
                break;

            case 'siswa':
                return view('home_s', compact('student'));
                break;

            default:
                dd('berhasil login');
                // return view('auth.login', compact('status'));
        }
    }
}
