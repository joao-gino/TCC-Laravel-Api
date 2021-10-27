<?php

namespace App\Http\Controllers;

use App\Events\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function message(Request $req) {

        event(new Message($req->input('message'), $req->input('username')));

        return [];

    }
}
