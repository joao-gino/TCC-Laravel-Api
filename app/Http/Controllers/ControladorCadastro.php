<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MailController;
use Illuminate\Http\Request;

class ControladorCadastro extends Controller
{
    public function cadastro(Request $req)
    {
        try {
            \DB::beginTransaction();

            $user = \DB::table('app_users')->where('email', $req->email)->get();

            if (!empty($user[0])) { // Se a variável $user não estiver vazia...

                return response()->json(['message' => 'Usuário já existe.'], 400);

            } else {

                $strings = '0123456789abcdefghijklmnopqrstuvwxyz';

                $password = substr(str_shuffle($strings), 0, 10);
    
                $username = strtolower(explode('@', $req->email)[0]);
    
                $name = explode('.', $username);
                $firstname = ucwords($name[0]);
                $lastname = ucwords($name[1]);
    
                $password = sha1($password);
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

                $email = new MailController();
    
                $email->sendEmail($username, $password, $req->email, $firstname);
    
                return response()->json(["message" => "Usuário cadastrado com sucesso"], 201);

            }
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }

    public function recoveryPassword(Request $req)
    {
        try {
            \DB::beginTransaction();

            $user = \DB::table('app_users')->where('email', $req->email)->get();

            if (empty($user[0])) { // Se a variável $user estiver vazia...

                return response()->json(['message' => 'Usuário não existe.'], 400);

            } else {

                $strings = '0123456789abcdefghijklmnopqrstuvwxyz';

                $password = substr(str_shuffle($strings), 0, 10);

                $username = strtolower(explode('@', $req->email)[0]);

                $name = explode('.', $username);
                $firstname = ucwords($name[0]);
                $lastname = ucwords($name[1]);

                $email = new MailController();

                $email->sendEmailPassword($username, $password, $req->email, $firstname);

                $password = sha1($password);
                $token = rand(1111111, 9999999);

                \DB::table('app_users')->where('email', $req->email)->update([
                    'access_key' => $password,
                    'user_update' => 'admin',
                    'date_update' => now()
                ]);
    
                \DB::commit();
    
                return response()->json(['message' => 'Senha resetada. E-mail reenviado.'], 201);

            }
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
    }
}
