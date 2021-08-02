<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MailController;
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

            $strings = '0123456789abcdefghijklmnopqrstuvwxyz';

            $password = substr(str_shuffle($strings), 0, 10);

            $username = strtolower(explode('@', $req->email)[0]);

            $name = explode('.', $username);
            $firstname = ucwords($name[0]);
            $lastname = ucwords($name[1]);

            $email = new MailController();

            $email->sendEmail($username, $password, $req->email, $firstname);

            $password = sha1($req->password);
            $token = rand(1111111, 9999999);

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
            return 'Obtivemos um erro.';
        }
    }
}
