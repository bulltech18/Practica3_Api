<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        $comentario = new Comentario;
        
        $e = $request->user()->email;
        $UserId= DB::table('users')->select('id')->where('email', '=', $e)->first();
        $comentario->cuerpo = $request->cuerpo;
        $comentario->publicacion_id = $request->publicacion_id;
        $comentario->user_id = $UserId->id;
        $comentario->save();
        if($comentario->save()){
            ComentarioController::enviarCorreoPublicacion($request->publicacion_id,$e,$request->cuerpo);
            $id= $UserId->id;
            ComentarioController::enviarEmail($id);
            return response()->json([
                                "comentario" => Comentario::find($comentario->id)
                                ]);
            
        }
       

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function show(Comentario $comentario)
    {
        $comentarios = ($id==0)? Comentario::all():Comentario::find($id);
        return response()->json($comentarios,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comentario $comentario)
    {
        $actualizado = Comentario::find($id);
        $actualizado->cuerpo = $cuerpo;
        $actualizado->save();

        return response()->json('Actualizado',202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comentario $comentario)
    {
        Comentario::destroy($id);
        return response()->json('Eliminado',200);
    }

    public function comentarioPubli(int $publicacion_id, int $id = NULL){
        return response()->json([
         'Respuesta'=>($id==null)?
         Comentario::where('publicacion_id', $publicacion_id)->get():
         Comentario::where('publicacion_id', $publicacion_id)->where('id', $id)->get()   
        ], 200);

    }
    public function personaPublicacionComent(int $persona_id, int $publicacion_id, int $id = NULL){
        return response()->json([
         'Respuesta'=>($id==null)?
         Comentario::where('persona_id', $persona_id)->where('publicacion_id', $publicacion_id)->get():
         Comentario::where('persona_id', $persona_id)->where('publicacion_id', $publicacion_id)->where('id', $id)->get()
        ], 200);

    }
    public function mostrarTodo(){
       return response()->json([
           'Respuesta' => DB::table('comentarios')->join('publicacions', 'publicacions.id','=','comentarios.publicacion_id')->join('personas', 'personas.id', '=' , 'comentarios.persona_id')->select('comentarios.*', 'publicacions.*', 'personas.*')->get()

       ], 200); 
    }
    public static function enviarEmail($UserId){
        $comentario = DB::table('users')->select('email')->where('id','=',$UserId)->first();
        $data = Array(

            'correo'=>$UserId,

        );
        Mail::send('email.comentSuccess',$data, function($message) use ($comentario){
            $message->from('19170174@uttcampus.edu.mx'); 
            $message->to($comentario->email)->subject('Comentario Nuevo');
        });
        
    }
    public static function enviarCorreoPublicacion($publicacion, $usuario, $comentario){
        $infoPublicacion = DB::table('publicacions')->where('id','=',$publicacion)->first();
        $autor = DB::table('users')->select('email')->where('id','=',$infoPublicacion->user_id)->first();
        $data = array(
            'titulo' => $infoPublicacion->titulo,
            'cuerpo' => $infoPublicacion->cuerpo,
            'usuario' => $usuario,
            'comentario' => $comentario
            );
            Mail::send('email.notComentPubli', $data, function ($message) use ($autor){
                $message->from('19170174@uttcampus.edu.mx', 'Notificacion');
                $message->to($autor->email)->subject('Notificacion');
            });
    }
}
