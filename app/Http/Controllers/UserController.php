<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\User;
use Illuminate\Validation\ValidationException;


class UserController extends Controller 
{
    public function guardarArchivo(Request $request){
        if($request->hasFile('file')){
           // $extension = $request->file('file');  //->extension();
             $path = Storage::disk('public')->putFile('archivos/img',$request->file); 
        }
            return response()->json(["Respuesta"=>$path],201);
    }

    public function registroUsuario(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $usuario = new User();
        if($request->hasFile('file')){
            $extension = $request->file('file')->extension();
            if($extension == 'png' || $extension == 'jpeg' || $extension == 'jpg'){
                $path = Storage::disk('public')->putFile('img',$request->file);
                $usuario->foto = $path;
            }else {
                return response()->json(['Error'=>'Extension desconocida'],400);
            }
        }else{
            $usuario->foto = "";
        }
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password =Hash::make($request->password);
        $usuario->persona_id = $request->persona_id;
        $usuario->rol = $request->rol;
       
 
        if($usuario->save())
            UserController::sendEmail($request);
            return response()->json($usuario,201);
            

        return abort(400,"No es posible registrarse");
        
        


    }

    public function logIn(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $usuario = User::where('email', $request->email)->first();
        
        if(! $usuario || ! Hash::check($request->password, $usuario->password)){
          
            return abort(401, "Credenciales Incorrectas");
        }

        if($usuario->rol == "Admin"){
            $token = $usuario->createToken($request->email,['Admin'])->plainTextToken;
        }
        else if($usuario->rol == "User"){
            $token = $usuario->createToken($request->email,['Usuario'])->plainTextToken;
        }
        
        return response()->json(["token"=>$token],201);
    }

    public static function sendEmail(request $request){

       $data = array(
            'name' => "Saludo",
            'email' => $request->email
        );

        Mail::send('email.bienvenida', $data, function ($message) use ($request){
            $message->from('19170174@uttcampus.edu.mx', 'API');
            $message->to($request->email)->subject('Demostracion');

            

        });

            return "Tu email se envio satisfactoriamente";

    }

    public function verificar(String $email){
        $usuario = User::where('email', $email)->first();

        if($usuario){
            $usuario->email_verified_at = NOW();
            $usuario->save();
            return redirect('http://127.0.0.1:8000/');
        }
        return abort('Invalido', 401);


    }

    public function logOut(Request $request){

      return response()->json(['usuarios'=>$request->user()->tokens()->delete()],200);
    }
   

     
   
}

