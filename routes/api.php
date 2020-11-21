<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Guardar Un archivo
Route::post('archivo', 'UserController@guardarArchivo');

//Registro de una persona
Route::GET('registro/persona', 'PersonaController@create')->middleware('verificar.edad');

//Registro de un usuario
Route::POST('registro/user', 'UserController@registroUsuario');

//Iniciar Sesion
Route::POST('login/user', 'UserController@logIn')->middleware('verificar.email');


//Verificar que el usuario este usando un token
Route::middleware('auth:sanctum')->group(function () {

//PERMISOS DE USUARIO

//Cerrar Sesion
Route::delete('logout/user', 'UserController@logOut');

Route::put('personas/update/{id?}/{nombre?}/{apellido?}/{edad?}/{sexo?}','PersonaController@update')->where(['id'=>'[0-9]+','nombre'=>'[A-Z,a-z]+',
'apellido'=>'[A-Z,a-z]+','edad'=>'[0-9]+','sexo'=>'[A-Z,a-z]+']);

Route::get('comentarios/crear','ComentarioController@create');

Route::put('comentarios/actualizar/{id?}')->where( 'id','[0-9]+');

Route::delete('comentarios/eliminar/{id}','ComentarioController@destroy')->where('id','[0-9]+');


Route::post('publicaciones/crear','PublicacionController@create');

Route::put('publicaciones/update/{id}/{titulo?}/{cuerpo?}/{persona_id?}','PublicacionController@update')->where(['id'=>'[0-9]+','titulo'=>'[A-Z,a-z]+',
'cuerpo'=>'[A-Z,a-z]+','persona_id'=>'[0-9]+']);

Route::delete('publicaciones/eliminar/{id?}','PublicacionController@destroy')->where( 'id','[0-9]+');

Route::get('superheroapi/personaje','SuperHeroController@buscarHeroe'); //BUSCA A UN SUPER HEROE O VILLANO POR SU NOMBRE Y DEVUELVE TODA SU INFORMACION

Route::get('superheroapi/{id}/biografia','SuperHeroController@biografiaHeroe'); //MUESTRA LA BIOGRAFIA DE UN SUPERHEROE O VILLANO BUSCANDOLO POR SU ID

Route::get('superheroapi/{id}/imagen','SuperHeroController@imagenHeroe'); //RESPONDE CON LA IMAGEN DE UN SUPERHEROE O VILLANO BUSCANDOLO POR SU ID

//AQUI TERMINAN LOS PERMISOS DE USUARIO

});

//PERMISOS DE ADMINISTRADOR
Route::middleware('auth:sanctum','verificar.rol')->group(function () {
 
    Route::get('personas/{id?}','PersonaController@show')->where( 'id','[0-9]+');
    
    Route::get('/buscar/persona/{persona}/publicacion/{publicacion?}','PublicacionController@publicacionPersona')->where(
        [
            'persona' => '[0-9]+',
            'publicacion' =>'[0-9]+'
        ]
    );
    Route::get('comentarios/{id?}','ComentarioController@show')->where( 'id','[0-9]+');

    Route::get('publicaciones/{id?}','PublicacionController@show')->where( 'id','[0-9]+');


    Route::get('persona/{persona_id}/comentario/{id?}','ComentarioController@consultaPersona')
    ->where( ['id','[0-9]+','persona_id','[0-9]+']);

    Route::get('personas/{persona_id}/publicaciones/{publicacion_id}/comentarios/{id?}', 'ComentarioController@personaPublicacionComent')->where( ['publicacion_id','[0-9]+','id','[0-9]+','persona_id','[0-9]+']);

    Route::get('comentarios/publicaciones/personas', 'ComentarioController@mostrarTodo');

    Route::get('publicacion/{publicacion_id}/comentario/{id?}', 'ComentarioController@comentarioPubli')->where( ['publicacion_id','[0-9]+','id','[0-9]+']);
    
    Route::get('usuarios/index', 'UserController@index'); //index
    });

    //AQUI TERMINAN LOS PERMISOS DE ADMINISTRADOR

//Ruta para confirmar el correo electronico
Route::GET('confirmacion/{email}', 'UserController@verificar');