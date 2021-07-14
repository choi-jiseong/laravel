<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        $user = Socialite::driver('google')->stateless()->user();
        //  dd($user);

        $user = User::firstOrCreate(
            ['email' => $user->getEmail()],
            ['password'=> Hash::make(Str::random(24)),
             'name'=> $user->getName()],
        );

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

}
