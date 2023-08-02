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
        $fechahoy = date("d-m-Y")
    @endphp

    <form action="/averias" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <div class="card" >

                    <div class="row">
                        <div class="col-2">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-input type="number"  name="Folio" label="Folio" placeholder="Folio"   required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <div class="row">
                                    {{-- <div class="col">
                                        @php
                                        $config = [
                                            'format' => 'DD-MM-YYYY',
                                            'maxDate' => "js:moment().endOf('day')"
                                        ];
                                        @endphp
                                        <x-adminlte-input-date name="Fecha" label="Fecha" placeholder="dd/mm/aaaa" :config="$config" required/>
                                    </div> --}}
                                    <div class="col">
                                        <label for="">Fecha</label>
                                        <input type="date" name="fecha" id="fecha" max="$fechahoy" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-select id="linea_id" name="Linea" label="Linea" fgroup-class="col-md-25" required>
                                            <option value="0" selected>--Seleccione la línea--</option>
                                            @foreach ($lineas as $item)
                                                <option value="{{ $item -> id }}">{{ $item -> nombre_linea }}</option> 
                                            @endforeach
                    
                                        </x-adminlte-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-input type="number" name="Numero" label="Numero" placeholder="Numero" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        @php
                                            $config = ['format' => 'LT'];
                                        @endphp
                                        <x-adminlte-input-date id="hora" name="Hora" label="Hora" :config="$config" placeholder="hh:mm"   required/>
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
                                        <x-adminlte-select id="estacion_id" name="Linea" label="Estacion o interestación" fgroup-class="col-md-25" required>
                                            <option value="0"selected>--Seleccione una estación o interestación --</option>
                                        </x-adminlte-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-input id='vias' name="vias" label="Via" placeholder="Via"  required/>
                                    </div>
                                    <div class="col">
                                        <br>
                                        <button type="button" class="btn btn-link" id="viaSR">SR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                
                                <div class="row">
                                    <label for="Motrices"></label>
                                    <div class="col">
                                        <x-adminlte-input id="motriz1" type="number" name="motriz1" required/>
                                    </div>
                                    <div class="col">
                                        <x-adminlte-input id="motriz2" type="number" name="motriz2" required/>
                                    </div>
                                    <div class="col">
                                        <x-adminlte-input id="cve_motrices"  name="cve_motrices" hidden required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p id='material'></p>
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-link" id="motrizV">Verificar</button>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-input type="number"  name="notren" label="Tren" placeholder="Tren" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-input id="carro" name="carro" label="Carro en falla" placeholder="Carro en falla" required/>
                                    </div>
                                    <div class="col">
                                        <br>
                                        <button type="button" class="btn btn-link" id="carroSR">SR</button>
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
                                        <x-adminlte-textarea name="descripcion" label="Descripción de la falla" placeholder="Descripcion de la falla"/>
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
                                        <x-adminlte-select name="tipoaveria" label="Tipo de averia" required>
                                            <option selected>--Seleccione la averia--</option>
                                            @foreach ($averias as $item)
                                            <option value="{{ $item -> tipo }}">{{ $item -> tipo }}.- {{ $item -> descripcion }}</option>   
                                            @endforeach                    
                                        </x-adminlte-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-head">
                                    Retardo
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <x-adminlte-input type="number"  name="minutos" label="Minutos"/>
                                        </div>
                                        <div class="col">
                                            <x-adminlte-input type="number"  name="segundos" label="Segundos"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col">
                                        <x-adminlte-input type="number" name="vueltas" label="Vueltas perdidas"/>
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
                                                        <x-adminlte-input id="expCond" type="number" label="Expediente" name="conductorN"/>
                                                    </div>
                                                    <div class="col">
                                                        <x-adminlte-input id="nomCond" name="conductor" label="Nombre" disabled/>
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
                                                Regulador
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <x-adminlte-input id="expReg" type="number" label="Expediente" name="conductorN"/>
                                                    </div>
                                                    <div class="col">
                                                        <x-adminlte-input id="nomReg" name="conductor" label="Nombre" disabled/>
                                                    </div>
                                                    <div class="col-2">
                                                        <br>
                                                        <x-adminlte-button label="verificar" theme="secondary"/>
                                                    </div>   
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <p id="catReg"></p>
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
                                                Jefe de Reguladores
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <x-adminlte-input id="expJReg" type="number" label="Expediente" name="conductorN"/>
                                                    </div>
                                                    <div class="col">
                                                        <x-adminlte-input id="nomJReg" name="conductor" label="Nombre" disabled/>
                                                    </div>
                                                    <div class="col-2">
                                                        <br>
                                                        <x-adminlte-button label="verificar" theme="secondary"/>
                                                    </div>   
                                                </div>  
                                                <div class="row">
                                                    <div class="col">
                                                        <p id="catJReg"></p>
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
                                        <x-adminlte-select id="funcion_id" name="funcion" label="Función de Tren" required>
                                            <option selected>--Seleccione una opcion--</option>
                                        </x-adminlte-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="row">
                                    <div class="col-5">
                                        <x-adminlte-select name="desalojado" label="Desalojado/Evacuado" required>
                                            <option selected>No se desalojo</option>
                                            <option>Tren Completo</option>
                                            <option>Carro/Parcial</option>
                                        </x-adminlte-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" >
                        <div class="col" style="text-align: center">
                            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </form>
@stop

@section('js')

<script>
    let linea = 0
    let motriz1 = 0
    let motriz2 = 0
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    
    $(document).ready(function(){
        document.getElementById('linea_id').addEventListener('change',
        (e)=>{
            console.log(e.target.value);
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
                console.log(data.estacion[1].descripcion);
                var opciones="<option value='0' selected>--Seleccione una estación o interestación --</option>"
                for(let i in data.estacion){
                    opciones+= '<option value="'+data.estacion[i].estacion+'">'+data.estacion[i].descripcion+'</option>';
                }
                document.getElementById("estacion_id").innerHTML=opciones;
                let funciones="<option value='0' selected>--Seleccione una funcion --</option>"
                for(let i in data.funcion){
                    funciones+= '<option value="'+data.funcion[i].id_estacion+'">'+data.funcion[i].descripcion+'</option>';
                }
                for(let i in data.funcion2){
                    funciones+= '<option value="'+data.funcion2[i].id_estacion+'">'+data.funcion2[i].descripcion+'</option>';
                }
                document.getElementById("funcion_id").innerHTML=funciones;
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
            /* fetch('/averias/getm',{
                    method : 'POST',
                    body: JSON.stringify({
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
                        document.getElementById("material").innerHTML=data[0].material
                    }else{
                        document.getElementById("cve_motrices").value=0
                        document.getElementById("material").innerHTML="No existe"
                    }
                }).catch(error => console.error(error)); */
        })

        document.getElementById('viaSR').addEventListener('click',(e)=>{
            document.getElementById('vias').value="SIN REFERENCIA"
        })

        document.getElementById('carroSR').addEventListener('click',(e)=>{
            document.getElementById('carro').value="SIN REFERENCIA"
        })

        document.getElementById('motrizV').addEventListener('click',(e)=>{
            let tren = (motriz1<motriz2 ?  motriz1+"/"+motriz2 : motriz2+"/"+motriz1)
            
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
                    }else{
                        document.getElementById("cve_motrices").value=0
                        document.getElementById("material").innerHTML='<i class="fa fa-times"></i>  '+"No existe"
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

        document.getElementById('hora').addEventListener('change', (e)=>{
            console.log(e.target.value);
        })


    });
    
</script>

@stop