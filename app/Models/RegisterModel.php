<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class RegisterModel
{
    public function register($voornaam, $achternaam, $email, $wachtwoord)
    {
        DB::table('gebruikers')->insert([
            'Voornaam' => $voornaam,
            'Achternaam' => $achternaam,
            'Email' => $email, 
            'Wachtwoord' => $wachtwoord,
            'Gebruikersnaam' => $email, 
            'AangemaaktOp' => now(),
        ]);
    }
}
