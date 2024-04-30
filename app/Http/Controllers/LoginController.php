<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Exception;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    public function register(Request $request){
        $user = $request->input();
        $user['password'] = bcrypt($user['password']);
        $nuevoUsuario = Usuario::create($user);
        $token = $nuevoUsuario->createToken('auth_token');
        return response()->json([
            'data'  =>  $nuevoUsuario,
            'access_token' => $token
        ]);
    }
    
    public function InicioNormal(Request $request){
        $credentials = $request->only('username', 'password');
        
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        } else {
            $usuario = Usuario::where('username','=',$credentials['username'])->first();

            if(!$usuario->enabled){
                auth()->logout();
                return response()->json([
                    'mensaje' => 'Usuario no autorizado'
                ],401);
            }

            $token = $usuario->createToken('auth_token');

            return response()->json([
                'usuario' => $usuario->only('username','email','updated_at'),
                'token' => $token->plainTextToken
            ],200);
            
        }

    }

    // Envía la solicitud a Google
    public function redirectToGoogle()
    {
        if(Auth::check()) redirect()->intended(route('Solicitud'));
        return Socialite::driver('google')->redirect();
    }

    // Respuesta desde Google, iniciar sesión
    public function handleGoogleCallback()
    {
        
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        $usuario = Usuario::where('email', $googleUser->getEmail());

        if(!$usuario || !$usuario->enabled){
            return redirect()->intended(env('FRONT_URL'),404)->with([
                'error' => 'Error al iniciar sesión'
            ]);
        }

        if(!isset($usuario->google_id)){
            $usuario->google_id = $googleUser->getId();
            $usuario->save();
        }

        Auth::login($usuario);
        $token = $usuario->createToken('auth_token');
        
        return redirect()->intended(env('FRONT_URL'))->with([
            'usuario'=>$usuario->only('username','email','updated_at'),
            'token'=>$token->plainTextToken
        ]);
    }

    //Cierra la sesión de Auth
    public function CerrarSesion(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Ha cerrado sesión'
        ],200);
    }
}
