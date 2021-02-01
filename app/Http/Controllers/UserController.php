<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $req)
    {
        return $req->user();
    }
    
    public function login(Request $req)
    {
        $user = User::whereEmail($req->email)->first();
        if (!is_null($user) && Hash::check($req->password, $user->password)) {

            $responseArray = [];
            $responseArray['token'] = $user->createToken('MoneyRegister')->accessToken;
            $responseArray['name'] = $user->name;
            
            return response()->json($responseArray, 200);
        } else
            return response()->json(['error' => 'Unauthenticated'], 203);
    }

    public function logout(){
        $user = auth()->user();
        $user->tokens->each(function ($token, $key){
            $token->delete();
        });
        return response()->json(['res' => true, 'message' => "Adios"], 200);
    }
    
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'name'=> 'required',
            'email'=> 'required|email',
            'password'=> 'required',
            'c_password'=> 'required|same:password',
            ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 202);
        }else
        {
            $input = $req->all();
            $input['password'] = bcrypt($input['password']);

            $user = User::create($input);

            $responseArray = [];
            $responseArray['token'] = $user->createToken('MoneyRegister')->accessToken;
            $responseArray['name'] = $user->name;
            
            return response()->json($responseArray, 200);
        }
    }
    
}
