<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verification; // Tambahkan ini
use App\Mail\OtpEmail;       // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; // Tambahkan ini
use Illuminate\Support\Str;          // Tambahkan ini untuk Str::random jika diperlukan
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|max:50',
        ]);
        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            return redirect('/');
        }
        return back()->with('failed','Email atau Password Salah!');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $request['status']="verify";
        $user = User::create($request->all());
        Auth::login($user);
        return redirect('/');
    }

    public function google_redirect(){
        return Socialite::driver('google')->redirect();
    }
    
    public function google_callback(){
        $googleUser = Socialite::driver('google')->user();
        $user = User::whereEmail($googleUser->email)->first();
        if(!$user){
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)),
                'role' => 'customer',
                'status' => 'verify',
                'avatar' => $googleUser->avatar]);
        } else {
            if (!$user->avatar && $googleUser->avatar) {
            $user->avatar = $googleUser->avatar;
            $user->save();
            }
        }
        
        if($user && $user->status == 'banned'){
            return redirect('/login')->with('failed', ' Akun anda telah di bekukan!');
        }

        Auth::login($user);

         // Jika belum verifikasi
        if ($user->status === 'verify') {
        return redirect('/verify');
        }

        // Jika admin
        if ($user->role === 'admin') {
        return redirect('/'); // atau sesuaikan
        }

        // Jika user biasa
        return redirect('/');
    }

}