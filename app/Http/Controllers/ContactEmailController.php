<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactEmail;

class ContactEmailController extends Controller
{
    public function sendEmailContact(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'content' => 'required|string',
        ]);

        // Préparer les données pour l'email
        $data = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'content' => $request->content,
        ];
        // Si les champs ne sont pas tous nuls, sauvegarder les données dans la base de données
        $mail = new ContactEmail();
        $mail->full_name = $request->full_name;
        $mail->email = $request->email;
        $mail->subject = $request->subject;
        $mail->content = $request->content;
        $mail->save();

        // Envoyer un email avec la vue originale
        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $recipientEmail = 'contact@compawnion.com';
            $senderName = "{$data['full_name']} • From Compawnion";

            $subject = $data['subject'] ?? '';

            $message->to($recipientEmail)
                ->subject($subject)
                ->from($data['email'], $senderName);
        });

        return redirect()->back()->with(['message' => 'Email envoyé!']);
    }
}
