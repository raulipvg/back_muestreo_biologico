<?php

namespace App\Http\Controllers;

use App\Models\GrupoProvilegio;
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
        $credentials = $request->only('email', 'password');

        try{
            if (!Auth::attempt($credentials)) {
                session()->invalidate();
                session()->regenerateToken();
                return response()->json(['error' => 'Credenciales incorrectas'], 401);
            } 
            else {
                $usuario = Usuario::where('email','=',$credentials['email'])->first();
    
                if(!$usuario || !$usuario->enabled){
                    auth()->logout();
                    return response()->json([
                        'error' => 'Error al iniciar sesión'
                    ],401);
                }
    
                $token = $usuario->createToken('auth_token');
                $permisos = $usuario->grupoPrivilegios();
                return response()->json([
                    'usuario' => $usuario->only('username','email','updated_at'),
                    'token' => $token->plainTextToken,
                    'permisosM' => json_encode($permisos['Privilegios']),
                    'permisosF'=> json_encode($permisos['Formularios'])
                ],200);
                
            }
        }catch(Exception $e){
            session()->invalidate();
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }
    }

    // Envía la solicitud a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Respuesta desde Google, iniciar sesión
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $usuario = Usuario::where('email','=', $googleUser->getEmail())->first();

        if(!$usuario || !$usuario->enabled){
            return response()->json([
                'error' => 'Error al iniciar sesión'
            ],401);
        }

        Auth::login($usuario);
        $token = $usuario->createToken('auth_token');

        $permisos = $usuario->grupoPrivilegios();
        return response()->json([
            'usuario'=>$usuario->only('username','email','updated_at'),
            'token'=>$token->plainTextToken,
            'permisosM' => json_encode($permisos),
            'permisosF' => json_encode($permisos)
        ],200);
    }

    //Cierra la sesión de Auth
    public function CerrarSesion(Request $request){
        $request->user()->tokens()->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Ha cerrado sesión'
        ],200);
    }
}
