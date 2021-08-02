<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail($username, $password, $email, $firstname) 
    {
        $details = [
            'username' => $username,
            'password' => $password,
            'firstname' => $firstname
        ];

        Mail::to($email)->send(new TestMail($details));

        return 'Email enviado';
    }
}
