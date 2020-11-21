<?php

namespace App\Http\Controllers;

use App\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
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
        $registroNuevo = new Persona;
        $registroNuevo->nombre = $request -> nombre;
        $registroNuevo->apellido = $request -> apellido;
        $registroNuevo->edad = $request-> edad;
        $registroNuevo->sexo = $request -> sexo;

        $registroNuevo->Save();
        return response()->json('Complete',202);
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
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        $personas= ($id==0)? Personas::all():Personas::find($id);
        return response()->json($personas,200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        $actualizar = Personas::find($id);

        $actualizar->nombre = $nombre;
        $actualizar->apellido = $apellido;
        $actualizar->edad = $edad;
        $actualizar->sexo = $sexo;

        $actualizar->Save();
        return response()->json('Complete',202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $eliminarPersona = \App\Personas::find($id);
        $eliminarPersona->delete();
        return response()->json([
                                "mensaje" => "persona eliminada",
                                "persona" => \App\Personas::all()
                                ],200);
    }
}
