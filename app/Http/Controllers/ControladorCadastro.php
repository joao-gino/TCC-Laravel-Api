<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorCadastro extends Controller
{
    public function __construct()
    {

    }

    public function cadastro(Request $req)
    {
        try {
            \DB::beginTransaction();

            $username = strtolower(explode('@', $req->email)[0]);
            $password = sha1($req->password);
            $token = rand(1111111, 9999999);
            $name = explode('.', $username);
            $firstname = ucwords($name[0]);
            $lastname = ucwords($name[1]);

            \DB::table('app_users')->insert([
                'username' => $username,
                'access_key' => $password,
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $req->email,
                'token' => $token,
            ]);

            \DB::commit();

            return response()->json(200);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }
}
