@extends('adminlte::page')

@section('title', 'Averias MR')

@section('content_header')
    <h1 class="m-0 text-dark"> Consulta de Averias</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <x-adminlte-datatable id="table1" :heads="$heads" head-theme='dark' with-buttons scrollable hoverable with-footer beautify bordered footer-theme='dark' >
            @forelse ($averias as $item)
                <tr>
                        <th>{{ $item -> id }}</th>
                        <th>{{ $item -> folio}}</th>
                        <th>{{ $item -> numero }}</th>
                        <th>{{ $item -> fecha }}</th>
                        <th>{{ $item -> falla }}</th>
                </tr>
            @empty
                <tr>Sin videojuegos</tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
</div>
    
@stop

@section('js')


@stop