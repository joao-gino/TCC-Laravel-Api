<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorLogin extends Controller
{
    public function login(Request $req)
    {
        $username = $req->username;
        $password = sha1($req->password);

        $user = \DB::table('app_users')->where('username', $username)->where('access_key', $password)->get();

        if (empty($user[0]))
        {
            return response()->json(['mensagem' => 'Credenciais incorretas'], 400);
        } else {
            return response()->json(['mensagem' => 'Autenticado com sucesso!'], 200);
        }
    }
}
