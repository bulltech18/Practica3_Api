<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class SuperHeroController extends Controller
{
    public function buscarHeroe(request $request){

        $respuesta = Http::get('https://superheroapi.com/api/3512730618792251/search/' .$request->name);
        return $respuesta->json();

    }
    
    public function biografiaHeroe(request $request, int $id){

        $respuesta = Http::get('https://superheroapi.com/api/3512730618792251/' .$id .'/biography');
        return $respuesta->json();

    }

    public function imagenHeroe(request $request, int $id){

        $respuesta = Http::get('https://superheroapi.com/api/3512730618792251/' .$id .'/image');
        return $respuesta->json();

    }
}
