<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iluminate\Support\Facades\Validator;
use Iluminate\Support\Facades\Auth;

use App\Models\Users;
use App\Models\Unit;

class AuthController extends Controller
{
    public function anauthorized(){
        return response()->json([
            'error' => 'NÃO AUTORIZADO'
        ], 401);
    }

    public function register (Rquest $request){
        $array = [ 'error'=>''];

        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'cpf'=> 'required|digits:11|unique:users,cpf',
            'password'=> 'required',
            'password_confirm'=> 'required|same:password'
        ]);

        if(!$validator->fails()){
            $name = $request->input('name');
            $email = $request->input('email');
            $cpf = $request->input('cpf');
            $password = $request->input('password');


            $hash = password_hash($password, PASSWORD_DEFAULT);

            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->cpf = $cpf;
            $newUser->password = $hash;

            $newUser->save();

            $token= auth()->attempt([
                'cpf'=>$cpf,
                'password'=>$password
            ]);

            if(!$token){
                $array['error'] = 'ERROR';
                return $array;
            }

               $array['token'] = $token;

                $user = auth()->user();
                $array['user'] = $user;

                $properties = Unit::select(['id', 'name'])->where('id_owner',$user['id'])->get();

                $array['user']['propeties'] = $properties;

        }else{
            $array['error']=$validator->error()->first();
            return $array;
        }

        return $array;
    }

    public function login(Request $request){
        $array = ['array'=>''];

        $validator = Validator::make($request->all(),[
            'cpf'=> 'required|digits:11',
            'password'=> 'required'
        ]);

        if(!$validator->fails()){
            $cpf = $request->input('cpf');
            $password = $request->input('password');

            $token= auth()->attempt([
                'cpf'=>$cpf,
                'password'=>$password
            ]);

            if(!$token){
                $array['error'] = 'error';
                return $array;
            }

               $array['token'] = $token;

                $user = auth()->user();
                $array['user'] = $user;

                $properties = Unit::select(['id', 'name'])->where('id_owner',$user['id'])->get();

                $array['user']['propeties'] = $properties;

        }else{
            $array['error'] = $validator->error->first();
            return $array;
        }
    }

    public function validateToken(){
        $array = ['error'=>''];

        $user = auth()->user();
        $array['user'] = $user;

        $properties = Unit::select(['id'],'name')->where('id_owner',$user['id'])->get();

        $array['user']['properties'] = $properties;

        return $array;
    }

    public function logout(){
        $array = ['error'=> ''];
        auth()->logout();
        return $array();
    }
}
