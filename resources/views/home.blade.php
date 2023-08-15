@extends('adminlte::page')

@section('title', 'Averias MR')

@section('content_header')
    <h1 class="m-0 text-dark">Sistema de Registro de Averias del Material Rodante</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Bienvenido al sistema de averias de material rodante</p>
                </div>

                <h4>Bienvenido {{ auth()->user()->name}} </h4>
            </div>
        </div>
    </div>
@stop
