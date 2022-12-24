<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * 
     */
    public function login() {
        return view('user.login');
    }

    /**
     * 
     * 
     */
    public function auth(Request $request) {
        
        $credentials = $request->validate([
            'email' => "required|email",
            'password' => "required",
        ], [
            'email.required' => 'Veuillez saisir votre adresse email',
            'email.email' => 'Veuillez saisir une adresse email valide',
            'password' => 'Veuillez saisir votre mot de passe'
        ]);
 
        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    /**
     * 
     */
    public function create() {
        return view('user.signup');
    }

    /**
     * 
     * 
     */
    public function store(Request $request) {

        $request->validate([
            'first_name'    => 'required|regex:/^[a-z]{3,}$/i',
            'last_name'     => 'required|regex:/^[a-z]{3,}$/i',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'role'          => 'required|in:0,1'
        ], [
            'first_name.required' => 'Veuillez saisir votre prenom',
            'first_name.regex' => 'Le prenom doit être composé au mois par 3 caractères alphabétiques',
            'last_name.required' => 'Veuillez saisir votre nom',
            'last_name.regex' => 'Le nom doit être composé au mois par 3 caractères alphabétiques',
            'email.required' => 'Veuillez saisir votre adresse email',
            'email.email' => 'Veuillez saisir une adresse email valide',
            'email.unique' => 'L\'email a été déja utilisé par un autre utilisateur',
            'password.required' => 'Veuillez saisir votre mot de passe',
            'password.min' => 'Le mot de passe doit être composé au mois par 6 caractères',
            'role.required' => 'Veuillez sélectionner votre role',
            'role.in' => 'Le role sélectionner est invalide'
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

        $user->save();
        
        Auth::login($user, true);

        return redirect()->route('home');


    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('login');

    }

}
