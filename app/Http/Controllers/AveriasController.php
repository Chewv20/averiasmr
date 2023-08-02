<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class AveriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lineas = DB::connection('pgsql2')->table('lineas')
        ->orderBy('id','asc')
        ->get();
        return view("averias-create",compact('lineas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function get_estaciones(Request $request){
        if(isset($request -> texto)){
            $estaciones = DB::connection('pgsql2')->table('estaciones')
            ->where('linea',$request->texto)
            ->orderBy('estacion','asc')
            ->get();
            $funciones = DB::connection('pgsql2')->table('funciones')
            ->where('linea',$request->texto)
            ->orderBy(('linea'))
            ->get();
            $funciones2 = DB::connection('pgsql2')->table('funciones')
            ->where('linea','00')
            ->orderBy(('linea'))
            ->get();
            $respuesta = [
                'estacion' => $estaciones,
                'funcion' => $funciones,
                'funcion2' => $funciones2
            ]; 

            return response()->json($respuesta,200);
        }
    }

    public function get_motrices(Request $request){

        $consulta = DB::connection('pgsql2')->table('trenes')
        ->where([['linea','LIKE',$request->linea],
        ['motrices',$request->tren],
        ['status','S']
        ])
        ->get();
        return response()->json($consulta,200);
    }
    public function getPlantilla(Request $request){
        if(isset($request -> personal)){
            $personal = DB::connection('pgsql3')
            ->table('plantilla')
            ->where('expediente',$request -> personal)
            ->get();
            if($personal){
                return response()->json($personal,200);
            }else{
                return 0;
            }
        }
    }

}
