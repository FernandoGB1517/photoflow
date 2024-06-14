@extends('layouts.app')

@section('titulo')
    Página Principal
@endsection

@section('contenido')
    <div class="px-4">
        <x-listar-post :posts="$posts" />
    </div>
@endsection