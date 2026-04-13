@extends('layouts.master')

@section('titulo', 'Inicio')

@section('contenido')
    <div class="portada-destacada">
        <h2>Bienvenido a TELLIT</h2>
        <p class="text-gray mt-2">Descubre, comparte y vive el cine.</p>
    </div>

    <h3 class="section-title">Reseñas Recientes</h3>
    <div class="cuadricula cuadricula-3 mb-4">
        <a href="#" class="tarjeta">
            <div class="flex mb-2">
                <div class="foto-perfil avatar-mini">A</div>
                <div>
                    <div class="font-bold text-small">Usuario A</div>
                    <div class="text-yellow text-small">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
            <p class="text-gray text-small">"Una obra maestra del género..."</p>
        </a>
    </div>

    <div class="cuadricula cuadricula-3">
        <div class="home-grid-span-2">
            <h3 class="section-title">Añadidos Recientes</h3>
            <div class="cuadricula cuadricula-4">
                <a href="#" class="tarjeta">
                    <div class="imagen-relleno imagen-tarjeta-inicio">Peli A</div>
                </a>
                <a href="#" class="tarjeta">
                    <div class="imagen-relleno imagen-tarjeta-inicio">Serie B</div>
                </a>
                <a href="#" class="tarjeta">
                    <div class="imagen-relleno imagen-tarjeta-inicio">Peli C</div>
                </a>
                <a href="#" class="tarjeta">
                    <div class="imagen-relleno imagen-tarjeta-inicio">Docu D</div>
                </a>
            </div>
        </div>
        <div class="caja-aleatoria">
            <div class="random-icon">🎲</div>
            <h3>¿No sabes qué ver?</h3>
            <p class="text-gray text-small mb-4">Serie o Película, aquí lo encontrarás.</p>
            <a href="#" class="boton boton-primario btn-block">Pincha Aquí</a>
        </div>
    </div>
@endsection