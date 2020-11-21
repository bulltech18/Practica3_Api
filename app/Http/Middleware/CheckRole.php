<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->tokenCan('Usuario'))
        {

            $usuario= $request->user()->email;
            $url= $request->url();
            CheckRole::enviarCorreo($usuario, $url);
            abort(403, "No se puede carnal perdoname neta es mi trabajo");

            

        }
        return $next($request);
       
    }
    public static function enviarCorreo($usuario, $url){
        $correosAdmin = DB::table('users')->select('email')->where('rol','=','Admin')->get();
        foreach ($correosAdmin as $admin) {
            $data = array(
            'usuario' => $usuario,
            'url' => $url
            );
            Mail::send('email.notAdmin', $data, function ($message) use ($admin){
                $message->from('19170174@uttcampus.edu.mx', 'Infiltracion');
                $message->to($admin->email)->subject('Acceso No Autorizado');
            });
        }
    }
}
