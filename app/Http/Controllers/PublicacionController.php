<?php

namespace App\Http\Controllers;

use App\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PublicacionController extends Controller
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
        
        $publicacion = new Publicacion;
        if($request->hasFile('file')){
            $extension = $request->file('file')->extension();
            if($extension == 'png' || $extension == 'jpeg' || $extension == 'jpg'){
                $path = Storage::disk('public')->putFile('img',$request->file);
                $publicacion->imagen = $path;
            }else {
                return response()->json(['Error'=>'Extension desconocida'],400);
            }
        }else{
            $publicacion->imagen = "";
        }
        $e = $request->user()->email;
        $UserId= DB::table('users')->select('id')->where('email', '=', $e)->first();
        $publicacion->titulo = $request->titulo;
        $publicacion->cuerpo = $request->cuerpo;
        $publicacion->user_id = $UserId->id;

        $publicacion->save();
        return response()->json('Complete',200);
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
     * @param  \App\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function show(Publicacion $publicacion)
    {
        $publicaciones = ($id==0)? Publicacion::all():Publicacion::find($id);
        return response()->json($publicaciones,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Publicacion $publicacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publicacion $publicacion)
    {
        $actualizar = Publicacion::find($id);
        $actualizar->titulo = $titulo;
        $actualizar->cuerpo= $cuerpo;
        $actualizar->save();
        return response()->json('Modificada correctamente', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publicacion $publicacion)
    {
        Publicacion::destroy($id);
        return response()->json('Eliminado',202);
    }
}
