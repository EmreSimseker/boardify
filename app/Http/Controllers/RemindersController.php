<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;

class RemindersController extends Controller
{
    public function sendReminders()
    {
        //haal datum van morgen op
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        //haal alle agenda items op
        $items = AgendaModel::with('user')->whereDate('Datum', $tomorrow)->get();

        foreach ($items as $item) {
            //check als user bestaat
            if (!$item->user) {
                error_log("Geen gebruiker gevonden voor agenda-item: {$item->Id}");
                continue;             }

            $email = $item->user->Email;
            $subject = "Reminder: Deadline morgen - {$item->Titel}";
            $body = $this->generateHtml($item);

            //verstuur de mail
            $this->sendMail($email, $subject, $body);
        }

        return "Reminders verstuurd voor {$tomorrow}";
    }

    private function generateHtml($item)
    {
        return '
        <!DOCTYPE html>
        <html lang="nl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reminder</title>
            <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
            <style>
                body {
                    font-family: \'Nunito\', Arial, sans-serif;
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
                    color: white !important; /* Zorgt dat de tekst wit is */
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
            <div class="email-container">
                <div class="header">
                    Reminder: Deadline Morgen
                </div>
                <div class="body">
                    <h2>Hallo!</h2>
                    <p>Dit is een herinnering dat je morgen (<strong>' . $item->Datum . '</strong>) een gebeurtenis hebt gepland:</p>
                    <p><strong>Taak:</strong> ' . $item->Titel . '</p>
                    <p><strong>Omschrijving:</strong> ' . ($item->Omschrijving ?: 'Geen omschrijving beschikbaar') . '</p>
                    <p>We wensen je veel succes!</p>
                    <a href="http://127.0.0.1:8000/boards/agenda" class="button">Bekijk Agenda</a>
                </div>
                <div class="footer">
                    © 2025 Boardify. Alle rechten voorbehouden.
                </div>
            </div>
        </body>
        </html>';
    }
    
    private function sendMail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'noreplyboardify@gmail.com';
            $mail->Password   = 'pkuk qoaa gyyc piub';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('noreplyboardify@gmail.com', 'Boardify Agenda');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
        } catch (Exception $e) {
            error_log("Mail Error: {$mail->ErrorInfo}");
        }
    }
}
