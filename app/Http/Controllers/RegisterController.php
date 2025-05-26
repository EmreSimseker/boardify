<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisterModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;



class RegisterController extends Controller
{
    public function index()
    {
        return view('register', ['step' => session('step', 'register')]);  
    }

    public function register(Request $request)
    {   //valideren
        $request->validate([
            'voornaam' => 'required|string|max:255',
            'achternaam' => 'required|string|max:255',
            'email' => 'required|email|unique:gebruikers,email',
            'wachtwoord' => 'required|string|confirmed|min:8',  
        ]);

        $verificationCode = rand(100000, 999999);
        //onthouden van gegevens
        session([
            'register_data' => [
                'voornaam' => $request->voornaam,
                'achternaam' => $request->achternaam,
                'email' => $request->email,
                'wachtwoord' => $request->wachtwoord
            ]
        ]);

        if ($this->verifyEmail($request->email, $verificationCode)) {
            //zet registratie stap naar verify (opent de verificatie modal)
            session(['verificationCode' => $verificationCode, 'step' => 'verify']);
            return redirect()->route('register')->with('succes', '');
        } else {
            return redirect()->back()->with('error', 'E-mailverificatie is mislukt.');
        }
    }

    public function verifyEmail($email, $verificationCode)
    {
        $mail = new PHPMailer(true);
    
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'noreplyboardify@gmail.com'; 
            $mail->Password = 'pkuk qoaa gyyc piub'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            $mail->setFrom('noreplyboardify@gmail.com', 'Boardify');
            $mail->addAddress($email);
    
            $mail->isHTML(true);
            $mail->Subject = 'Welkom bij Boardify!';
    
            $mail->Body = "
            <!DOCTYPE html>
            <html lang='nl'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Welkom bij Boardify!</title>
                <link href='https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap' rel='stylesheet'>
                <style>
                    body {
                        font-family: 'Nunito', Arial, sans-serif;
                        background-color: #f7f9fc;
                        margin: 0;
                        padding: 0;
                        color: #333;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 20px auto;
                        background: #ffffff;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        overflow: hidden;
                        border: 1px solid #e0e0e0;
                    }
                    .header {
                        background: linear-gradient(to bottom right, #004953, #007b76);
                        color: white;
                        text-align: center;
                        padding: 20px;
                        font-size: 26px;
                        font-weight: bold;
                    }
                    .body {
                        padding: 20px;
                        line-height: 1.8;
                        font-size: 16px;
                    }
                    .body h2 {
                        color: #004953;
                        font-size: 22px;
                        margin-bottom: 15px;
                    }
                    .body p {
                        margin: 10px 0;
                        color: #555;
                    }
                    .body p strong {
                        color: #333;
                        font-weight: bold;
                    }
                    .button {
                        display: inline-block;
                        background: linear-gradient(to bottom right, #004953, #007b76);
                        color: white !important;
                        text-decoration: none;
                        padding: 12px 25px;
                        border-radius: 5px;
                        font-size: 16px;
                        font-weight: bold;
                        margin-top: 20px;
                    }
                    .button:hover {
                        background: #005e63;
                    }
                    .footer {
                        text-align: center;
                        background: #f0f0f0;
                        padding: 15px;
                        font-size: 14px;
                        color: #666;
                        border-top: 1px solid #e0e0e0;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>
                        Welkom bij Boardify!
                    </div>
                    <div class='body'>
                        <h2>Hallo!</h2>
                        <p>Welkom bij Boardify, waar je jouw taken kunt beheren en organiseren.</p>
                        <p>Om verder te gaan met je registratie, gebruik de volgende verificatiecode:</p>
                        <p><strong>Verificatiecode:</strong> $verificationCode</p>
                        <p>We wensen je veel succes met het beheren van je taken!</p>
                    </div>
                    <div class='footer'>
                        © 2025 Boardify. Alle rechten voorbehouden.
                    </div>
                </div>
            </body>
            </html>";
    
            $mail->send();
    
            Log::info('Verificatiecode succesvol verzonden naar ' . $email);
    
            return true;
        } catch (Exception $e) {
            Log::error('Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
    


    public function verifyCode(Request $request)
    {
        //haal opgeslagen gegevens uit sessie
        $enteredCode = $request->input('verificationCode');
        $storedCode = session('verificationCode');

        if ($enteredCode == $storedCode) {
            $registerData = session('register_data');
            if ($registerData) {
                $model = new RegisterModel();
                $model->register(
                    $registerData['voornaam'],
                    $registerData['achternaam'],
                    $registerData['email'],
                    bcrypt($registerData['wachtwoord']) 
                );

                session()->forget('register_data');
                session()->forget('verificationCode');
                session()->forget('step');

                return redirect('/login')->with('succes', 'Verificatie geslaagd! Je kunt nu inloggen.');
            }
        } else {
            return redirect()->back()->with('error', 'Onjuiste verificatiecode.');
        }
    }
    //functie om opnieuw te beginnen met registreren
    public function reset()
    {
        Session::forget('step'); 
        Session::forget('verification_code'); 

        return redirect()->route('register')->with('succes', 'Je kunt opnieuw registreren.');
    }
}
