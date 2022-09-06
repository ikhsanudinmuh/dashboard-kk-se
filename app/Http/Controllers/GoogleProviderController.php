<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class GoogleProviderController extends Controller
{
    public function redirect() {
        //mengeluarkan halaman login google
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        //mengambil data akun google yang login
        $user = Socialite::driver('google')->user();

        //validasi jika email kosong atau tidak ditemukan
        if (empty($user->email)) {
            return redirect('/login');
        }

        //mencari data atau membuat data baru dari user yang login
        $auth_user = $this->findOrCreateUser($user);

        //validasi user yang login
        if($auth_user){
            Auth::loginUsingId($auth_user->id);
            request()->session()->put('user', Auth::user());

            return redirect('/')->with('loginSuccess', 'Login successful');
        }

        return redirect('/login')->with('loginFailed', 'Login must use SSO Telkom University');
    }

    public function findOrCreateUser($providerUser)
    {
        //mencari data user berdasarkan email
        $user = User::where('email', $providerUser->getEmail())->first();

        //validasi jika user tidak ditemukan, maka akan dibuat user baru
        if(!$user) {
            // $validEmail = preg_match(
            //     "/([A-Za-z0-9._%+-]+@student.telkomuniversity.ac.id$)|([A-Za-z0-9._%+-]+@telkomuniversity.ac.id$)/",
            //     $providerUser->email);

            $user = null;

            // if ($validEmail) {
                $user = User::create([
                    'name' => $providerUser->name,
                    'email' => $providerUser->email,
                    'google_id' => $providerUser->id,
                    'role' => 'user',
                    'email_verified_at' => Carbon::now(),
                ]);
            // }
        }

        return $user;
    }
}
