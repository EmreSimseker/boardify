<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $gebruiker = DB::table('gebruikers')->where('Email', $request->email)->first();

        if ($gebruiker && Hash::check($request->password, $gebruiker->Wachtwoord)) {
            Session::put('gebruiker', $gebruiker);

            return redirect('/boards');  
        }

        return back()->with('error', 'Ongeldige inloggegevens');
    }

    public function logout()
    {
        Session::forget('gebruiker');

        return redirect('/');
    }
}
