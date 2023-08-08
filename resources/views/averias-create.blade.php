@extends('adminlte::page')

@section('title', 'Averias MR')

@section('content_header')
    <h1 class="m-0 text-dark"> Registro de Reportes de Averías de Trenes y Trenes Evacuados </h1>
@stop

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
           -webkit-appearance: none;
            margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@section('content')
    @php
        $tR = 0;
        $tJR = 0;
        $eR = 99999;
        $eJR = 99999;
        $fechahoy = date("d-m-Y");
        if (isset($turnoReg)) {
            $tR = $turnoReg;
        }
        if (isset($turnoJReg)) {
            $tJR = $turnoJReg;
        }
        if (isset($expedienteReg)) {
            $eR = $expedienteReg;
        }
        if (isset($expedienteJR)) {
            $eJR = $expedienteJR;
        }
    @endphp

    {{-- Message --}}
    @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Éxito !</strong> {{ session('success') }}
    </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/averias" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <div class="card" >

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                {{-- <p>El turno del regulador es: {{ $tR }}</p>
                                <p>El turno del jefe regulador es: {{ $tJR }}</p>
                                <p>El expediente del regulador es: {{ $eR }}</p>
                                <p>El expediente del jefe regulador es: {{ $eJR }}</p>
                                <p>la fecha es: {{ $fechahoy }}</p> --}}
                                <div class="row">
                                    <div class="col-3">
                                        <x-adminlte-select id="turnoReg" name="turnoReg" label="Turno Regulador"  required>
                                            <option value="" @if (0== $tR ) selected @endif>--Seleccione el turno--</option>
                                            <option value="1" @if (1== $tR ) selected @endif>Primer Turno</option>
                                            <option value="2" @if (2== $tR ) selected @endif>Segundo Turno</option>
                                            <option value="3"@if (3== $tR ) selected @endif>Tercer Turno</option>
                                            <option value="4"@if (4== $tR ) selected @endif>Cuarto Turno</option>
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col-2">
                                        <x-adminlte-input id="expReg" type="number" value='{{ $eR }}' label="Expediente" name="expedienteReg" required/>
                                    </div>
                                    <div class="col">
                                        <x-adminlte-input id="nomReg" name="regulador" label="Nombre" disabled/>
                                    </div>
                                    <div class="col-2">
                                        <br>
                                        <x-adminlte-button id="reguladorV" label="verificar" theme="secondary"/>
                                    </div>  
                                </div>

                                <div class="row">
                                    <div class="col">
                                        
                                    </div>
                                    <div class="col">
                                        <p id="catReg"></p> 
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class="col-3">
                                        <x-adminlte-select id="turnoJReg" name="turnoJefeReg" label="Turno Jefe Regulador"  required>
                                            <option value="" @if (0== $tJR ) selected @endif>--Seleccione el turno--</option>
                                            <option value="1" @if (1== $tJR ) selected @endif>Primer Turno</option>
                                            <option value="2" @if (2== $tJR ) selected @endif>Segundo Turno</option>
                                            <option value="3" @if (3== $tJR ) selected @endif>Tercer Turno</option>
                                            <option value="4" @if (4== $tJR ) selected @endif>Cuarto Turno</option>
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col-2">
                                        <x-adminlte-input id="expJReg" type="number" value='{{ $eJR }}' label="Expediente" name="expedienteJR" requiered/>
                                    </div>
                                    <div class="col">
                                        <x-adminlte-input id="nomJReg" name="jeferegN" label="Nombre" disabled/>
                                    </div>
                                    <div class="col-2">
                                        <br>
                                        <x-adminlte-button id="jefeRV" label="verificar" theme="secondary"/>
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col">
                                        
                                    </div>
                                    <div class="col">
                                        <p id="catJReg"></p> 
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-input type="number" min="0" name="folio" label="Folio" placeholder="Folio"   required/>
                                    </div>
                                    <div class="col">
                                        <label for="">Fecha</label>
                                        <input type="date" name="fecha" id="fecha" required>
                                    </div>
                                    <div class="col">
                                        <x-adminlte-select id="linea_id" name="linea" label="Linea" fgroup-class="col-md-25" required>
                                            <option value="" selected>--Seleccione la línea--</option>
                                            @foreach ($lineas as $item)
                                                <option value="{{ $item -> id }}">{{ $item -> nombre_linea }}</option> 
                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col">
                                        <x-adminlte-input type="number" min=0 name="numero" label="Numero" placeholder="Numero" required/>
                                    </div>
                                    <div class="col">
                                        <label for="">Hora</label>
                                        <div class="cs-form">
                                            <input type="time" id="hora" name="hora" class="form-control" required />  
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <x-adminlte-input id='vias' name="via" label="Via" placeholder="Via" onkeyup="mayus(this);" required/>
                                    </div>
                                    <div class="col-1">
                                        <br>
                                        <p class="btn btn-link" id="viaSR">SR</p>
                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-select id="estacion_id" name="estacion" label="Estacion o interestación" fgroup-class="col-md-25" required>
                                            <option value=""selected>--Seleccione una estación o interestación --</option>
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col-1">
                                        <label for="">Motrices</label>
                                        <x-adminlte-input id="motriz1" name="motriz1" min=0 type="number" required/>
                                    </div>
                                    <div class="col-1">
                                        <label for="">.</label>
                                        <x-adminlte-input id="motriz2" name="motriz2" min=0 type="number" required/>
                                    </div>
                                    
                                    <div class="col-1">
                                        <br>
                                        <p id='material'></p>
                                    </div>
                                    <div class="col-1">
                                        <br>
                                        <p class="btn btn-link" id="motrizV">Verificar</p>
                                    </div>
                                    <div class="col-1">
                                        <x-adminlte-input type="number"  name="tren" label="Tren" min=0 max=80 placeholder="Tren" required/>
                                    </div>
                                    <div class="col-2">
                                        <x-adminlte-input id="carro" name="carro" label="Carro en falla" placeholder="Carro en falla" onkeyup="mayus(this);" required/>
                                    </div>
                                    <div class="col-1">
                                        <br>
                                        <p class="btn btn-link" id="carroSR">SR</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-textarea name="falla" label="Descripción de la falla" placeholder="Descripción de la falla" onkeyup="mayus(this);" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-select name="tipo" label="Tipo de averia" required>
                                            <option value="" >--Seleccione la averia--</option>
                                            @foreach ($averias as $item)
                                            <option value="{{ $item -> tipo }}">{{ $item -> tipo }}.- {{ $item -> descripcion }}</option>   
                                            @endforeach                    
                                        </x-adminlte-select>
                                    </div>
                                    <div class="col">
                                        <div class="card">
                                            <label for="">Retraso</label>
                                            <div class="row">
                                                <div class="col">
                                                    <x-adminlte-input type="number"  id="minutos_R" name="minR" min=0 label="Minutos"/>
                                                </div>
                                                <div class="col">
                                                    <x-adminlte-input type="number"  id="segundos_R" name="segR" min=0 max="59" label="Segundos"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card">
                                            <label for="">Duracion del incidente</label>
                                            <div class="row">
                                                <div class="col">
                                                    <x-adminlte-input type="number" id="minutos_D" name="minD" min=0 label="Minutos"/>
                                                </div>
                                                <div class="col">
                                                    <x-adminlte-input type="number"  id="segundos_D" name="segD" min=0 max="59" label="Segundos"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <x-adminlte-input type="number" name="vueltas" min=0 label="Vueltas perdidas"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col">
                            <div class="card">

                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-head">
                                                Conductor
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <x-adminlte-input id="expCond" type="number" label="Expediente" name="expedienteC"/>
                                                    </div>
                                                    <div class="col">
                                                        <x-adminlte-input id="nomCond" name="nombreC" label="Nombre" disabled/>
                                                    </div>
                                                    <div class="col-2">
                                                        <br>
                                                        <x-adminlte-button label="verificar" theme="secondary"/>
                                                    </div>   
                                                </div>  
                                                <div class="row">
                                                    <div class="col">
                                                        <p id="catCond"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-head">
                                                Persona que reporta
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <x-adminlte-input id="expRep" type="number" label="Expediente" name="elaboroE"/>
                                                    </div>
                                                    <div class="col">
                                                        <x-adminlte-input id="nomRep" name="nombreE" label="Nombre" disabled/>
                                                    </div>
                                                    <div class="col-2">
                                                        <br>
                                                        <x-adminlte-button label="verificar" theme="secondary"/>
                                                    </div>   
                                                </div>  
                                                <div class="row">
                                                    <div class="col">
                                                        <p id="catRep"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col" style="text-align: center">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-select id="funcion_id" name="funcion_tren" label="Función de Tren" required>
                                            <option value="" >--Seleccione una opcion--</option>
                                        </x-adminlte-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col-5">
                                        <x-adminlte-select name="evacua" label="Desalojado/Evacuado" required>
                                            <option value="N" >No se desalojo</option>
                                            <option value="T">Tren Completo</option>
                                            <option value="C">Carro/Parcial</option>
                                        </x-adminlte-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" >
                        <div class="col" style="text-align: center">
                            <x-adminlte-button class="btn-flat" type="submit" label="Enviar" theme="success" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <x-adminlte-input id="cve_motrices"  name="cve_motrices" hidden required/>
        <x-adminlte-input id="retardo" value="0" name="retardo" hidden />
        <x-adminlte-input id="duracion" value="0" name="duracion" hidden />
        <x-adminlte-input id="motrices_tren" name="motrices_tren" hidden required/>
        <x-adminlte-input id="materialT" name="material" hidden required/>
    </form>
@stop

@section('js')
<link href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<script>
    let linea = 0
    let motriz1 = 0
    let motriz2 = 0
    let retardo = 0
    let minutosR = 0
    let segundosR = 0
    let duracion = 0
    let minutosD = 0
    let segundosD = 0
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    
    $(document).ready(function(){

        document.getElementById('linea_id').addEventListener('change',
        (e)=>{
            
            fetch('/averias/get',{
                method : 'POST',
                body: JSON.stringify({texto : e.target.value}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response=>{
                return response.json()
            }).then( data=>{
                var opciones="<option value='' selected>--Seleccione una estación o interestación --</option>"
                for(let i in data.estacion){
                    opciones+= '<option value="'+data.estacion[i].estacion+'">'+data.estacion[i].descripcion+'</option>';
                }
                document.getElementById("estacion_id").innerHTML=opciones;
                let funciones="<option value='' selected>--Seleccione una funcion --</option>"
                for(let i in data.funcion){
                    funciones+= '<option value="'+data.funcion[i].id_funcion+'">'+data.funcion[i].descripcion+'</option>';
                }
                for(let i in data.funcion2){
                    funciones+= '<option value="'+data.funcion2[i].id_funcion+'">'+data.funcion2[i].descripcion+'</option>';
                }
                document.getElementById("funcion_id").innerHTML=funciones;
                document.getElementById("motriz1").value=0
                document.getElementById("motriz2").value=0

            }).catch(error => console.error(error));
            linea = e.target.value
        })
        
        document.getElementById('motriz1').addEventListener('change', (e)=>{   
            let aux = String(10000+parseInt(e.target.value))
            motriz1 = aux.substr(1,4)
        })

        document.getElementById('motriz2').addEventListener('change',(e)=>{
            let aux = String(10000+parseInt(e.target.value))
            motriz2 = aux.substr(1,4)
            
            let tren = (motriz1<motriz2 ?  motriz1+"/"+motriz2 : motriz2+"/"+motriz1)
            console.log(tren);
            //console.log("motriz2: "+tren);
            fetch('/averias/getm',{
                    method : 'POST',
                    body: JSON.stringify({
                        tren : tren,
                        motriz1 : motriz1,
                        motriz2 : motriz2,
                        linea : linea
                    
                    }),
                    headers:{
                        'Content-Type': 'application/json',
                        "X-CSRF-Token": csrfToken
                    }
                }).then(response=>{
                    return response.json()
                }).then( data=>{
                    if(data[0]){
                        document.getElementById("cve_motrices").value=data[0].cve_motrices
                        document.getElementById("material").innerHTML='<i class="fa fa-check"></i>  '+data[0].material
                        document.getElementById("motrices_tren").value=tren
                        document.getElementById("materialT").value=data[0].material
                    }else{
                        document.getElementById("material").innerHTML='<i class="fa fa-times"></i>  '+"No existe"
                        document.getElementById("cve_motrices").value=0
                    }
                }).catch(error => console.error(error));
        })

        document.getElementById('viaSR').addEventListener('click',(e)=>{
            document.getElementById('vias').value="SIN REFERENCIA"
        })

        document.getElementById('carroSR').addEventListener('click',(e)=>{
            document.getElementById('carro').value="SIN REFERENCIA"
        })

        document.getElementById('motrizV').addEventListener('click',(e)=>{
            let tren = (motriz1<motriz2 ?  motriz1+"/"+motriz2 : motriz2+"/"+motriz1)
            //console.log("boton: "+tren);
            fetch('/averias/getm',{
                    method : 'POST',
                    body: JSON.stringify({
                        tren : tren,
                        linea : linea
                    
                    }),
                    headers:{
                        'Content-Type': 'application/json',
                        "X-CSRF-Token": csrfToken
                    }
                }).then(response=>{
                    return response.json()
                }).then( data=>{
                    if(data[0]){
                        document.getElementById("cve_motrices").value=data[0].cve_motrices
                        document.getElementById("material").innerHTML='<i class="fa fa-check"></i>  '+data[0].material
                        document.getElementById("motrices_tren").value=tren
                        document.getElementById("materialT").value=data[0].material
                    }else{
                        document.getElementById("material").innerHTML='<i class="fa fa-times"></i>  '+"No existe"
                        document.getElementById("cve_motrices").value=0
                    }
                }).catch(error => console.error(error));
        })

        document.getElementById('expCond').addEventListener('change',(e)=>{
            console.log(e.target.value);
            fetch('/averias/getp',{
                method : 'POST',
                body: JSON.stringify({personal : e.target.value}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response=>{
                return response.json()
            }).then( data=>{
                if(data[0]){
                    console.log(data);
                    document.getElementById("nomCond").value=data[0].nombre;
                    document.getElementById("catCond").innerHTML=data[0].categoria
                }else{
                    console.log(data);
                    document.getElementById("nomCond").value="SIN NOMBRE (USUARIO UNIVERSAL)";
                    document.getElementById("expCond").value=99999;
                    document.getElementById("catCond").innerHTML="SIN CATEGORIA (CUALQUIER CATEGORIA)"
                }
            }).catch(error => console.error(error));
        })

        document.getElementById('expReg').addEventListener('change',(e)=>{
            console.log(e.target.value);
            fetch('/averias/getp',{
                method : 'POST',
                body: JSON.stringify({personal : e.target.value}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response=>{
                return response.json()
            }).then( data=>{
                if(data[0]){
                    console.log(data);
                    document.getElementById("nomReg").value=data[0].nombre;
                    document.getElementById("catReg").innerHTML=data[0].categoria
                }else{
                    console.log(data);
                    document.getElementById("nomReg").value="SIN NOMBRE (USUARIO UNIVERSAL)";
                    document.getElementById("expReg").value=99999;
                    document.getElementById("catReg").innerHTML="SIN CATEGORIA (CUALQUIER CATEGORIA)"
                }
            }).catch(error => console.error(error));
        })

        document.getElementById('expJReg').addEventListener('change',(e)=>{
            console.log(e.target.value);
            fetch('/averias/getp',{
                method : 'POST',
                body: JSON.stringify({personal : e.target.value}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response=>{
                return response.json()
            }).then( data=>{
                if(data[0]){
                    console.log(data);
                    document.getElementById("nomJReg").value=data[0].nombre;
                    document.getElementById("catJReg").innerHTML=data[0].categoria
                }else{
                    console.log(data);
                    document.getElementById("nomJReg").value="SIN NOMBRE (USUARIO UNIVERSAL)";
                    document.getElementById("expJReg").value=99999;
                    document.getElementById("catJReg").innerHTML="SIN CATEGORIA (CUALQUIER CATEGORIA)"
                }
            }).catch(error => console.error(error));
        })

        document.getElementById('expRep').addEventListener('change',(e)=>{
            console.log(e.target.value);
            fetch('/averias/getp',{
                method : 'POST',
                body: JSON.stringify({personal : e.target.value}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response=>{
                return response.json()
            }).then( data=>{
                if(data[0]){
                    console.log(data);
                    document.getElementById("nomRep").value=data[0].nombre;
                    document.getElementById("catRep").innerHTML=data[0].categoria
                }else{
                    console.log(data);
                    document.getElementById("nomRep").value="SIN NOMBRE (USUARIO UNIVERSAL)";
                    document.getElementById("expRep").value=99999;
                    document.getElementById("catRep").innerHTML="SIN CATEGORIA (CUALQUIER CATEGORIA)"
                }
            }).catch(error => console.error(error));
        })

        document.getElementById('funcion_id').addEventListener('change',(e)=>{
            console.log(e.target.value);
        })

        document.getElementById('reguladorV').addEventListener('click',(e)=>{
            var expReg = $("#expReg").val();
            console.log(expReg);
            fetch('/averias/getp',{
                method : 'POST',
                body: JSON.stringify({personal : expReg}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response=>{
                return response.json()
            }).then( data=>{
                if(data[0]){
                    console.log(data);
                    document.getElementById("nomReg").value=data[0].nombre;
                    document.getElementById("catReg").innerHTML=data[0].categoria
                }else{
                    console.log(data);
                    document.getElementById("nomReg").value="SIN NOMBRE (USUARIO UNIVERSAL)";
                    document.getElementById("expReg").value=99999;
                    document.getElementById("catReg").innerHTML="SIN CATEGORIA (CUALQUIER CATEGORIA)"
                }
            }).catch(error => console.error(error));
        })

        document.getElementById('jefeRV').addEventListener('click',(e)=>{
            var expReg = $("#expReg").val();
            console.log(expReg);
            fetch('/averias/getp',{
                method : 'POST',
                body: JSON.stringify({personal : expReg}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response=>{
                return response.json()
            }).then( data=>{
                if(data[0]){
                    console.log(data);
                    document.getElementById("nomJReg").value=data[0].nombre;
                    document.getElementById("catJReg").innerHTML=data[0].categoria
                }else{
                    console.log(data);
                    document.getElementById("nomJReg").value="SIN NOMBRE (USUARIO UNIVERSAL)";
                    document.getElementById("expJReg").value=99999;
                    document.getElementById("catJReg").innerHTML="SIN CATEGORIA (CUALQUIER CATEGORIA)"
                }
            }).catch(error => console.error(error));
        })
        
        document.getElementById('minutos_R').addEventListener('change',(e)=>{
            minutosR=parseInt(e.target.value*60)
            retardo=minutosR+segundosR
            document.getElementById('retardo').value=retardo
        })

        document.getElementById('segundos_R').addEventListener('change',(e)=>{
            segundosR=parseInt(e.target.value)
            retardo=parseInt(minutosR+parseInt(e.target.value))
            document.getElementById('retardo').value=retardo
        })

        document.getElementById('minutos_D').addEventListener('change',(e)=>{
            minutosD=parseInt(e.target.value*60)
            duracion=minutosD+segundosD
            document.getElementById('duracion').value=duracion
        })

        document.getElementById('segundos_D').addEventListener('change',(e)=>{
            segundosD=parseInt(e.target.value)
            duracion=parseInt(minutosD+parseInt(e.target.value))
            document.getElementById('duracion').value=duracion
        })

        document.getElementById('fecha').addEventListener('change',(e)=>{
            console.log(e.target.value);
            
            let today = new Date();
            let day = today.getDate();
            let month = today.getMonth() + 1;
            let year = today.getFullYear();
            let fechaS = String(e.target.value)

            let anioS = fechaS.substr(0,4)
            let mesS = fechaS.substr(5,2)
            let diaS = fechaS.substr(8,2)

            let anio = parseInt(anioS)
            let mes = parseInt(mesS)
            let dia = parseInt(diaS)

            if(anio>year){
                Swal.fire(
                    {icon: 'error',
                    title: 'Oops...',
                    text: 'Fecha erronea'}
                )
                document.getElementById('fecha').value=""
            }else{
                if(mes>month){
                    Swal.fire(
                    {icon: 'error',
                    title: 'Oops...',
                    text: 'Fecha erronea'}
                    )
                    document.getElementById('fecha').value=""
                }else if(mes == month){
                    if(dia>day){
                        Swal.fire(
                            {icon: 'error',
                            title: 'Oops...',
                            text: 'Fecha erronea'}
                        )
                        document.getElementById('fecha').value=""
                    }
                }
            }
            
        })

    });

    function mayus(e) {
        e.value = e.value.toUpperCase();
    }
    
</script>

@stop