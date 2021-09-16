<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        /*$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
        ]);*/

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'normal';
        $user->sector_id = $request->sector_id;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return response()->json([
                'message' => 'Usuario Criado com Sucesso',
                'status_code' => 201

            ], 201);
        } else {
            return response()->json([
                'message' => 'Ocoreu um erro ao tentar Registar um Usuario',
                'status_code' => 500
            ], 500);
        }
    }



    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                if ($user->role == 'administrator') {
                    $tokenData = $user->createToken('Personal Access Token', ['administrator']);
                } elseif($user->role == 'normal') {
                    $tokenData = $user->createToken('Personal Access Token', ['normal']);
                }else{
                    $tokenData = $user->createToken('Personal Access Token', ['gestor']);
                }

                $token = $tokenData->token;

                if ($request->remember_me) {
                    $token->expires_at = Carbon::now()->addWeeks(1);
                }

                if ($token->save()) {
                    return response()->json([
                        'user' => $user,
                        'access_token' => $tokenData->accessToken,
                        'token_type' => 'Bearer',
                        'token_scope' => $tokenData->token->scopes[0],
                        'expires_at' => Carbon::parse($tokenData->token->expires_at)->toDateTimeString(),
                        'status_code' => 200
                    ], 200);

                    header('Authorization', $token);
                } else {
                    return response()->json([
                        'message' => 'Ocoreu um erro',
                        'status_code' => 500
                    ], 500);
                }
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logout Com Sucesso',
            'status_code' => 200,
        ], 200);
    }


    public function meuperfil(Request $request){
        $user = User::orderBy('created_at', 'desc')
        ->join('pessoas', 'user_id', '=', 'users.id')
        ->where('id', '=',$request->user()->id)
        ->paginate(5);
        return response()->json($user, 200);
    }

    public function atualizarperfil(Request $request){

    }

    public function profile(Request $request)
    {
        if ($request->user()) {
            return response()->json($request->user(), 200);
        }

        return response()->json([
            'message' => 'Not LoggedIn',
            'status_code' => 500,
        ]);
    }
}
