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
            return response()->json(['data' => 'Credenciais incorretas'], 200);
        } else {
            return response()->json(['data' => 'Autenticado com sucesso!'], 200);
        }
    }
}
