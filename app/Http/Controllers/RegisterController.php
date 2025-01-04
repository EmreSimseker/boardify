<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisterModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register', ['step' => session('step', 'register')]);  // default is 'register'
    }

    public function register(Request $request)
    {
        $request->validate([
            'voornaam' => 'required|string|max:255',
            'achternaam' => 'required|string|max:255',
            'email' => 'required|email|unique:gebruikers,email',
            'wachtwoord' => 'required|string|confirmed|min:8',  
        ]);

        $verificationCode = rand(100000, 999999);

        session([
            'register_data' => [
                'voornaam' => $request->voornaam,
                'achternaam' => $request->achternaam,
                'email' => $request->email,
                'wachtwoord' => $request->wachtwoord
            ]
        ]);

        if ($this->verifyEmail($request->email, $verificationCode)) {
            session(['verificationCode' => $verificationCode, 'step' => 'verify']);
            return redirect()->route('register')->with('succes', 'Registratie succesvol. Verificatiecode is verzonden.');
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
            $mail->Subject = 'Verificatiecode';
            $mail->Body = "Uw verificatiecode is: $verificationCode";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function verifyCode(Request $request)
    {
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
}
