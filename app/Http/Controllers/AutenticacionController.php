<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutenticacionController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => ['required', 'email'],
            'contrasena' => ['required'],
        ]);

        $credenciales = [
            'correo' => $request->correo,
            'password' => $request->contrasena, // "password" es la clave que espera internamente Auth::attempt
        ];

        if (!Auth::attempt($credenciales, $request->boolean('recordar'))) {
            return back()->withErrors(['correo' => 'Credenciales incorrectas.'])->onlyInput('correo');
        }

        if (auth()->user()->estado !== 'activo') {
            Auth::logout();
            return back()->withErrors(['correo' => 'Tu cuenta está desactivada. Contacta al administrador.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('panel'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
