<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Validuje vstupy z registracneho formulara
     *
     * required = pole musi byt vyplenene
     * email = vstup musi byt vo formate emailu
     * role ponuka na vyber medzi donor a recipient
     */
    public function register(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:donor,recipient',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user); // automaticky prihlasi pouzivatela po uspesnej registracii

        return redirect()->route('home');
    }


    public function showRegisterForm() {
        return view('auth.register');
    }

    public function showLoginForm() {

        return view('auth.login');
    }

    /**
     * Prihlasi pouzivatela (teda aspon sa o to pokusi)
     */
    public function login(Request $request) {

            // prvotne len pozrie ci udaje splnaju podmienky vstupu
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            // pokus prihlasenia s udajmi od uzivatela
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                // regeneruje session ID po uspesnom prihlaseni, inak by sa mohlo zneuzit stare session ID z prihlasovania
                $request->session()->regenerate();
                return redirect()->route('home'); // po uspesnom prihlaseni routuje pouzivatela na homepage

            }
            // v pripade ze prihlasenie zlyha
            return back()->withErrors([
                'email' => 'Invalid credentials.'
            ]);

    }

    /**
     * Vrati pouzivatela na login page
    */
    public function logout(Request $request) {
            Auth::logout();

            // zrusi staru session
            $request->session()->invalidate();
            // vygeneruje novy CSRF token, aby sa predislo utokom po odhlaseni pouzivatela
            $request->session()->regenerateToken();

            // vrati pouzivatela na login page
            return redirect()->route('login.show');
    }

}
