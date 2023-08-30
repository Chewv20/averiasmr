<?php

namespace App\Http\Controllers;

use Illuminate\Console\View\Components\Alert;
use Illuminate\Contracts\Redis\Connection;
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
        //$averias = DB::select('select * from reportes order by id desc');
        $averias = DB::connection('pgsql2')
        ->table('reportes')
        ->where('id','LIKE','STC23%')
        ->orderBy('id','desc')
        ->get();
        return view('averias',compact('averias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $dependencias = DB::connection('pgsql')
        ->table('dependencias')
        ->get();

        $averias = DB::connection('pgsql2')
        ->table('tipos')
        ->where('status','S')
        ->orderBy('tipo','asc')
        ->get();

        
        return view("averias-create",compact('dependencias','averias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $fec_mov = date("Y-m-d");
        $hor_mov = date('H:i');
        $anio = substr($request->fecha,0,4);
        $consulta_id = DB::connection('pgsql2')
        ->table('folio')
        ->where('anio',$anio)
        ->select('id')
        ->get();
        $id2 = 100000+$consulta_id[0]->id+1;
        $id = "STC".substr(strval($anio),-2)."-".substr(strval($id2),1,5);
        $vigente ='S';
        $atendido = 'N';
        
        DB::insert('insert into reportes (id, turno_reg, expediente_reg, turno_jefereg, expediente_jefereg, bitacora, fecha, linea, numero, hora, via, estacion, tren, carro, falla, tipo, vueltas, expediente_c, expediente_reporta, funcion_tren, hora_funcion, evacua, cve_motrices, retardo, duracion_incidente, motrices_tren, material, usuario, fec_mov, hora_mov, vigente, atendido, dependencia) values(?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$id,$request->turnoReg, $request->expedienteReg, $request->turnoJReg, $request->expedienteJR,$request->folio,$request->fecha,$request->linea,$request->numero,$request->hora,$request->via,$request->estacion,$request->tren,$request->carro,$request->falla,$request->tipo,$request->vueltas,$request->conductor,$request->elaboro,$request->funcion_tren,$request->horaFuncion,$request->evacua,$request->motrices,$request->retardo,$request->duracion,$request->motrices_tren,$request->material,$request->usuario,$fec_mov,$hor_mov,$vigente,$atendido, $request->dependencia]);
        DB::connection('pgsql2')->update('update folio set id = ? where anio = ?', [$consulta_id[0]->id+1,$anio]);
        $respuesta = [
            'success' => true,
            'id' => $id
        ];
        return $respuesta;

        
        
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

    public function getL(Request $request)
    {
        $consulta = DB::connection('pgsql')
        ->table('lineas')
        ->where([
        ['dependencia',$request->dependencia],
        ])
        ->get();
        return response()->json($consulta,200);
    }

    public function get_estaciones(Request $request)
    {
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

    public function get_motrices(Request $request)
    {

        $consulta = DB::connection('pgsql2')->table('trenes')
        ->where([['linea','LIKE',$request->linea],
        ['motrices','LIKE','%'.$request->motriz1.'%'],
        ['motrices','LIKE','%'.$request->motriz2.'%'],
        ['status','S']
        ])
        ->get();
        return response()->json($consulta,200);
    }

    public function getPlantilla(Request $request)
    {
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

    public function getReporte(Request $request)
    {  
        $comprueba = DB::connection('pgsql2')->table('reportes')
        ->where([
            ['fecha',$request->fecha],
            ['hora',$request->hora],
            ['motrices',$request->motrices],
            ['estacion',$request->estacion],
            ['numero',$request->numero],
            ['bitacora',$request->bitacora]
        ])
        ->orderBy('fecha','desc')
        ->get(); 

        $comprueba2 = DB::connection('pgsql')->table('reportes')
        ->where([
            ['fecha',$request->fecha],
            ['hora',$request->hora],
            ['cve_motrices',$request->motrices],
            ['estacion',$request->estacion],
            ['numero',$request->numero],
            ['bitacora',$request->bitacora]
        ])
        ->orderBy('fecha','desc')
        ->get();
        
        $respuesta = [
            'primera' => $comprueba,
            'segunda' => $comprueba2
        ];
        return response()->json($respuesta,200);
        
    }

    public function get(Request $request)
    {

        $averias = DB::connection('pgsql2')
        ->table('reportes')
        ->whereDate('fecha','>=',$request->fecha,'and')
        ->whereDate('fecha','<=',$request->fecha2)
        ->orderBy('fecha','asc')
        ->get();

        $averias2 = DB::connection('pgsql')
        ->table('reportes')
        ->whereDate('fecha','>=',$request->fecha,'and')
        ->whereDate('fecha','<=',$request->fecha2)
        ->orderBy('fecha','asc')
        ->get();
        $respuesta = $averias -> concat($averias2);

        return datatables($respuesta)->toJson();
    }

}
