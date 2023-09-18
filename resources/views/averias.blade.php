@extends('adminlte::page')

@section('title', 'Averias MR')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@stop

@section('content_header')
    <h1 class="m-0 text-dark"> Consulta de Averias</h1>
@stop

@section('content')
@php
    $hoy = date("Y-m-d");
@endphp

<div>
    <label for="date">Fecha</label>
    <input id="fecha" type="date" value="<?php echo $hoy;?>" min="2020-11-04" max="<?php echo $hoy;?>">
    <label for="date"> a </label>
    <input id="fecha2" type="date" value="<?php echo $hoy;?>" min="2020-11-04" max="<?php echo $hoy;?>">
    <button type="button" id="filtro" class="btn btn-outline-success" >Aplicar Filtro</button>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped" id="averias" class="display">
            <thead>
                <th>ID</th>
                <th>Folio</th>
                <th>Numero</th>
                <th>Fecha</th>
                <th>Falla</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </thead>


        </table>
    </div>
</div>
    
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>


    <script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

    $(document).ready(function(){
        generaTabla()
        document.getElementById('filtro').addEventListener('click',(e)=>{
            $('#averias').DataTable().destroy()
            if(document.getElementById('fecha').value == '' ){
                document.getElementById('fecha').value='2023-01-01'
            }else if(document.getElementById('fecha2').value == ''){
                document.getElementById('fecha2').value='2023-01-01'
            }
            generaTabla()
        })
        
    })


    function generaTabla(){
        new DataTable('#averias', {
            responsive: true,
            autoWidth: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
            },
            ajax : {
                method : "POST",
                url : "/averias/geta",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data : { 
                    fecha : document.getElementById('fecha').value,
                    fecha2 : document.getElementById('fecha2').value,
                },
            },
            columns: [
                { data: 'id' },
                { data: 'bitacora' },
                { data: 'numero' },
                { data: 'fecha' },
                { data: 'falla' },
                { data: 'tipo' },
                {
                    "data": null,
                    "bSortable": false,
                    "Export": false,
                    "mRender": function(data, type, value) {
                        return '<a href="/averias/'+value["id"]+'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>Editar</a> <a href="/averias/delete/'+value["id"]+'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Eliminar</a>'
                        
                    }
                },
            ],
            dom: 'Blfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            select: true,
            "proccessing" : true,
            "serverSide": true,
            "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"] ],
            "pagingType": "full_numbers",
            "order": ['3','asc'],
        });
    }
    </script>

@stop