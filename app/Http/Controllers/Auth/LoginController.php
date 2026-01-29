<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Attempt to log the user into the application.
     * Support login dengan NIS atau email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        // 1. Khusus Login Siswa (NIS + Kode Sekolah)
        if ($request->has('nis') && $request->has('kode_guru')) {
            $nis = $request->input('nis');
            $kodeGuru = $request->input('kode_guru');
            $password = $request->input('password');

            // Decode Kode Guru menjadi Teacher ID
            $teacherId = \App\Models\Teacher::decodeTeacherCode($kodeGuru);

            if ($teacherId) {
                // Rangkai ulang menjadi email autentikasi: nis.teacherId@amal.web.id
                $email = $nis . '.' . $teacherId . '@amal.web.id';

                return $this->guard()->attempt(
                    ['email' => $email, 'password' => $password],
                    $request->filled('remember')
                );
            }

            return false;
        }

        // 2. Login Normal (Guru/Admin melalui Email)
        $credentials = $this->credentials($request);
        $username = $credentials[$this->username()] ?? null;

        // Auto-detect: jika input numeric, anggap NIS (Backward compatibility if still needed)
        if ($username && is_numeric($username)) {
            $student = Student::where('nis', $username)->first();
            if ($student) {
                $credentials[$this->username()] = $student->user->email;
            }
        }

        return $this->guard()->attempt(
            $credentials,
            $request->filled('remember')
        );
    }
}
