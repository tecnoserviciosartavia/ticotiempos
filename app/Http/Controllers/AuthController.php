<?php

namespace App\Http\Controllers;

use App\Http\Request\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function loginView()
    {
        return view('login.main', [
            'layout' => 'login'
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            throw new \Exception('Wrong email or password.');
        } else {
            if (Auth::user()->active == 0) {
                Auth::logout();
                Session::flash('message', "Su usuario no puede acceder al sistema.");
                throw new \Exception('Su usuario no puede acceder al sistema.');

            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
