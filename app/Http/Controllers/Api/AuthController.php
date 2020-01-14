<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends ResponseController
{
    /**
     * Create User
     * name, email, password, confirm_password
     * parameters as POST data
     * 
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        if ($user) {
            $success['token'] =  $user->createToken('token')->accessToken;
            $success['message'] = "Registro en Bachecubano completado";
            return $this->sendResponse($success);
        } else {
            $error = "Lo sentimos, no se pudo completar el registro";
            return $this->sendError($error, 401);
        }
    }

    /**
     * Login User
     * email, password
     * Parameters as POST data
     * 
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            $error = "No se ha podido autorizar";
            return $this->sendError($error, 401);
        }
        $user = $request->user();
        $success['token'] =  $user->createToken('token')->accessToken;
        return $this->sendResponse($success);
    }

    /**
     * Logout User
     */
    public function logout(Request $request)
    {
        $isUser = $request->user()->token()->revoke();
        if ($isUser) {
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        } else {
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
    }

    /**
     * Get MySelf User Data
     */
    public function getUser(Request $request)
    {
        $user = $request->user();
        if ($user) {
            return $this->sendResponse($user);
        } else {
            $error = "No se ha encontrado el usuario";
            return $this->sendResponse($error);
        }
    }
}
