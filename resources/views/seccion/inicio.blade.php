@extends('layouts.master')

@section('titulo', 'Inicio')

@section('contenido')
    <div class="hero">
        <h2>Bienvenido a TELLIT</h2>
        <p class="text-gray mt-2">Descubre, comparte y vive el cine.</p>
    </div>

    <h3 class="section-title">Reseñas Recientes</h3>
    <div class="grid grid-3 mb-4">
        <a href="#" class="card">
            <div class="flex mb-2">
                <div class="avatar" style="width:30px; height:30px; font-size:1rem; margin-right:10px;">A</div>
                <div>
                    <div class="font-bold text-small">Usuario A</div>
                    <div class="text-yellow text-small">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
            <p class="text-gray text-small">"Una obra maestra del género..."</p>
        </a>
    </div>

    <div class="grid grid-3">
        <div style="grid-column: span 2;">
            <h3 class="section-title">Añadidos Recientes</h3>
            <div class="grid grid-4">
                <a href="#" class="card">
                    <div class="placeholder-img" style="height: 140px;">Peli A</div>
                </a>
                <a href="#" class="card">
                    <div class="placeholder-img" style="height: 140px;">Serie B</div>
                </a>
                <a href="#" class="card">
                    <div class="placeholder-img" style="height: 140px;">Peli C</div>
                </a>
                <a href="#" class="card">
                    <div class="placeholder-img" style="height: 140px;">Docu D</div>
                </a>
            </div>
        </div>
        <div class="random-box">
            <div style="font-size: 3rem; margin-bottom: 10px;">🎲</div>
            <h3>¿Indeciso?</h3>
            <p class="text-gray text-small mb-4">Deja que el azar elija por ti.</p>
            <a href="#" class="btn btn-primary btn-block">Pincha Aquí</a>
        </div>
    </div>
@endsection