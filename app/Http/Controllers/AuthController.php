<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //valideer ingevoerde email en wachtwoord
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $gebruiker = DB::table('gebruikers')->where('Email', $request->email)->first();

        if ($gebruiker && Hash::check($request->password, $gebruiker->Wachtwoord)) {
            //zet gebruiker in de sessie
            Session::put('gebruiker', $gebruiker);

            return redirect('/boards');  
        }

        return back()->with('error', 'Ongeldige inloggegevens');
    }
    //uitloggen user 
    public function logout()
    {
        Session::forget('gebruiker');

        return redirect('/');
    }
}
