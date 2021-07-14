<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GithubAuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['guest']);  //로그인한 사용자이면 안되기 때문에
    }

    public function redirect(){
        return Socialite::driver('github')->redirect();
    }

    public function callback() {
        $user = Socialite::driver('github')->user();
        // dd($user);

        // db에 사용자 정보를 저장한다
        //이미 이 사용자 정보가 db에 저장되어 있다면
        //저장할 필요가 없다
        $user = User::firstOrCreate([
            'email' => $user->getEmail()],
            ['password' => Hash::make(Str::random(24)),
            'name' =>$user->getNickname()],
        );

        // 로그인 처리..
        Auth::login($user);

        return redirect()->intended('/dashboard'); //원래 가려는 곳이 있으면 그곳으로 보내준다
    }
}
