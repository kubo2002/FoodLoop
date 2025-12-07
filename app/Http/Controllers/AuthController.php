<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * REGISTER – uloženie nového používateľa
     *
     * Táto metóda spracuje registračný formulár.
     * Najskôr overujem (validujem) údaje, ktoré používateľ zadal.
     * Validácia prebehne na strane servera – Laravel automaticky vygeneruje
     * chybové hlášky a vráti ich späť do formulára.
     */
    public function register(Request $request) {

        // Validácia vstupov
        $request->validate([
            'name'     => 'required|string|max:255',      // meno musí byť vyplnené a text
            'email'    => 'required|email|unique:users,email', // email musí byť unikátny
            'password' => 'required|min:6|confirmed',     // confirmed = musí existovať aj password_confirmation
            'role'     => 'required|in:donor,recipient',  // povolené sú len dve role
        ]);

        // Uloženie nového používateľa do DB
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // heslo hashujem, nikdy neukladám ako text
            'role'     => $request->role,
        ]);

        // Po úspešnej registrácii používateľa automaticky prihlásim
        Auth::login($user);

        return redirect()->route('home'); // presmerovanie na hlavnú stránku
    }


    /**
     * Zobrazí registračný formulár (view)
     */
    public function showRegisterForm() {
        return view('auth.register');
    }

    /**
     * Zobrazí login formulár (view)
     */
    public function showLoginForm() {
        return view('auth.login');
    }


    /**
     * LOGIN – prihlásenie používateľa
     *
     * Overujem, či je email a heslo správne.
     * Pri chybe sa zobrazí vlastná hláška pomocou view().
     */
    public function login(Request $request) {

        /**
         * Najprv prebehne serverová validácia vstupov.
         * Ak email/heslo nie je vyplnené, Laravel automaticky zastaví metódu
         * a vráti späť chybové hlášky.
         */
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ],[
            'email.required'  => 'Email je povinný.',
            'email.email'     => 'Email musí byť platný.',
            'password.required' => 'Heslo je povinné.'
        ]);

        /**
         * Pokus o prihlásenie.
         * Auth::attempt() porovná email + hash hesla v DB.
         * Ak je login správny, vráti true.
         */
        if (Auth::attempt($validated)) {

            // Z bezpečnostných dôvodov zregenerujem session ID – ochrana proti session fixation útoku
            $request->session()->regenerate();

            // presmerovanie používateľa na homepage
            return redirect()->route('home');
        }

        /**
         * Ak prihlásenie zlyhalo:
         * - vráti sa späť login formulár
         * - zobrazí preklad 'loginFailed'
         * - starý email sa predvyplní, aby ho používateľ nemusel písať nanovo
         */
        return view('auth.login', [
            'login_failed' => __('messages.loginFailed'),
            'old_email'    => $request->email
        ]);
    }


    /**
     * LOGOUT – odhlásenie používateľa
     */
    public function logout(Request $request) {

        // Odhlásim používateľa
        Auth::logout();

        // Invalidujem starú session – odstránim všetky údaje
        $request->session()->invalidate();

        // Vytvorím nový CSRF token, aby som predišiel útokom po odhlásení
        $request->session()->regenerateToken();

        // presmerovanie na login page
        return redirect()->route('login.show');
    }
}
