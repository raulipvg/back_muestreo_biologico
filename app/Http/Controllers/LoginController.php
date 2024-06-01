<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\GrupoProvilegio;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Exception;
use Firebase\JWT\JWT;
use GPBMetadata\Google\Api\Log;
use Laravel\Socialite\Facades\Socialite;
use PhpParser\Node\Stmt\Return_;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


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
    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        try{
               if(!$token = JWTAuth::attempt($credentials)){
                    return response()->json([
                        'error' => 'Credenciales incorrectas'
                    ],400);
                }
        }catch(JWTException $e){
            return response()->json([
                'error' => 'Error al iniciar sesión'
            ],401);
        }
        $usuario = Usuario::where('email','=',$credentials['email'])->first();

        $persona = Persona::select('nombre','apellido')
                         ->where('id','=',$usuario->persona_id)
                         ->first();
         $permisos = $usuario->grupoPrivilegios();        
        
        //$token = JWTAuth::factory()->createToken($user, null, ['ttl' => 0.1]);
        return response()->json(
            [
                'usuario' => [
                    'username' => $usuario->username,
                    'email' => $usuario->email,
                    'updated_at' => $usuario->updated_at,
                    'firstname' => $persona['nombre'],
                    'lastname' => $persona['apellido']
                ],
                'token' => $token,
                'permisosM' => json_encode($permisos['Privilegios']),
                'permisosF'=> json_encode($permisos['Formularios'])
            ]
        );
        
    }

    public function logout(){

        try {
            JWTAuth::invalidate(JWTAuth::parseToken()); // Invalida el token actual
          } catch (JWTException $e) {
            return response()->json([
              'error' => 'Error al cerrar sesión'
            ], 401);
          }  
          return response()->json([
            'message' => 'Sesión cerrada exitosamente'
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
                $persona = Persona::select('nombre','apellido')
                         ->where('id','=',$usuario->persona_id)
                         ->first();
                $permisos = $usuario->grupoPrivilegios();
                return response()->json([
                    'usuario' => [
                        'username' => $usuario->username,
                        'email' => $usuario->email,
                        'updated_at' => $usuario->updated_at,
                        'firstname' => $persona['nombre'],
                        'lastname' => $persona['apellido']
                    ],
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

    /*
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
        $persona = Persona::select('nombre','apellido')
                         ->where('id','=',$usuario->persona_id)
                         ->first();
        $permisos = $usuario->grupoPrivilegios();
        return response()->json([
            'usuario' => [
                'username' => $usuario->username,
                'email' => $usuario->email,
                'updated_at' => $usuario->updated_at,
                'firstname' => $persona['nombre'],
                'lastname' => $persona['apellido']
            ],
            'token'=>$token->plainTextToken,
            'permisosM' => json_encode($permisos['Privilegios']),
            'permisosF'=> json_encode($permisos['Formularios'])
        ],200);
    }
    */
    
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
