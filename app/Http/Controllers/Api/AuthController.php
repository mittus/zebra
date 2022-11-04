<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
    
        if($validate->fails()) {
            return BaseController::error('Ошибка валидации', $validate->errors());       
        }
    
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('zebra')->plainTextToken;
    
        return BaseController::response($success, 'Пользователь зарегистрирова');
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user(); 
            $success['token'] =  $user->createToken('zebra')->plainTextToken;
    
            return BaseController::response($success, 'Пользователь авторизован');
        } else { 
            return BaseController::error('Unauthorised.', ['error' => 'Unauthorised']);
        } 
    }
}
