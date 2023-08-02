@extends('adminlte::page')

@section('title', 'Averias MR')

@section('content_header')
    <h1 class="m-0 text-dark">Lineas</h1>
@stop

@section('content')
    hola
    <table>
        @forelse ($estaciones as $item)
            <tr>
                <th>{{ $item -> id_estacion }}</th>
                <th>{{ $item -> nombre_estacion }}</th>
            </tr>
        @empty
            <tr>Sin videojuegos</tr>
        @endforelse
    </table>
@stop