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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $lineas = DB::connection('pgsql2')->table('lineas')
        ->orderBy('id','asc')
        ->get();
        $averias = DB::connection('pgsql2')
        ->table('tipos')
        ->where('status','S')
        ->orderBy('tipo','asc')
        ->get();

        $turnoReg = $request->session()->pull('turnoReg');
        $expedienteReg = $request->session()->pull('expedienteReg');
        $turnoJReg = $request->session()->pull('turnoJefeReg');
        $expedienteJR = $request->session()->pull('expedienteJR');

        
        return view("averias-create",compact('lineas','averias','turnoReg','expedienteReg','turnoJReg','expedienteJR'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->session()->put(['turnoReg'=>$request->turnoReg]);
        $request->session()->put(['expedienteReg'=>$request->expedienteReg]);
        $request->session()->put(['turnoJefeReg'=>$request->turnoJefeReg]);
        $request->session()->put(['expedienteJR'=>$request->expedienteJR]);
        
        $request->validate([
            'fecha' => 'required|date|before:today',
            'cve_motrices' => 'required|numeric|different:0'
        ],$message=['before'=>'Fecha erronea verificala','different'=>'Motrices erroneas']);

        $comprueba = DB::connection('pgsql2')->table('reportes')
        ->where([['fecha',$request->fecha],
        ['hora',$request->hora],
        ['motrices',$request->cve_motrices],
        ['estacion',$request->estacion],
        ['numero',$request->numero],
        ['bitacora',$request->folio]
        ])
        ->orderBy('fecha','desc')
        ->get();
        if(count($comprueba) != 0){
            return redirect()->route('averias.create')->with('error', 'El reporte ya existe.');
        }
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
        $ip=(getenv('HTTP_X_FORWARDED_FOR')? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR'));
        //$ip="50.192.168.1";
        $conductor = 99999;
        if($request -> expedienteC){
            $conductor = $request -> expedienteC;
        }
        $elaboro = 99999;
        if($request -> elaboroE){
            $elaboro = $request -> elaboroE;
        }
        $vueltas = 0;
        if($request->vueltas){
            $vueltas = $request->vueltas;
        }
        $minR=0;
        if($request->minR){
            $minR = $request->minR;
        }
        $segR=0;
        if($request->segR){
            $segR = $request->segR;
        }
        
        DB::connection('pgsql2')->insert('insert into reportes (fecha, hora, estacion, via, tren, carro, falla, retardo, conductor, elaboro, vobo, motrices, fec_mov, id, tipo, vueltas, vigente, retardo_m, retardo_s, evacua, hor_mov, atendido, numero, bitacora, ip_captura, motrices_tren, material, funcion_tren) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$request->fecha, $request->hora, $request->estacion, $request->via, $request->tren, $request->carro, $request->falla, $request->retardo, $conductor, $elaboro, $request->expedienteReg, $request->cve_motrices, $fec_mov, $id, $request->tipo, $vueltas, $vigente, $minR, $segR, $request->evacua, $hor_mov, $atendido, $request->numero, $request->folio, $ip, $request->motrices_tren, $request->material, $request->funcion_tren]);
        DB::connection('pgsql2')->update('update folio set id = ? where anio = ?', [$consulta_id[0]->id+1,$anio]);
        //return redirect()->route('averias.create')->with('success', 'Se guardo el reporte: '.$id);
        return $request;
        
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
        ['motrices','LIKE','%'.$request->motriz1.'%'],
        ['motrices','LIKE','%'.$request->motriz2.'%'],
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
