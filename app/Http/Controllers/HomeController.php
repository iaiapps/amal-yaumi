<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        /** @var User $user */
        $user = Auth::user();
        $role = $user->getRoleNames()->first();

        if ($role === 'admin') {
            return app(DashboardController::class)->admin();
        } elseif ($role === 'guru') {
            return app(DashboardController::class)->guru();
        } elseif ($role === 'siswa') {
            return app(DashboardController::class)->student();
        }

        return redirect()->route('login');
    }
}
