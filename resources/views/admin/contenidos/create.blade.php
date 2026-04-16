@extends('layouts.master')

@section('titulo', 'Importar desde TMDB')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        <style>
            .tmdb-search-container {
                position: relative;
                max-width: 600px;
                margin: 0 auto;
            }
            .tmdb-results {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #1f2937;
                border: 1px solid #374151;
                border-radius: 6px;
                margin-top: 5px;
                z-index: 10;
                max-height: 400px;
                overflow-y: auto;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
                display: none;
            }
            .tmdb-item {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 10px;
                border-bottom: 1px solid #374151;
                cursor: pointer;
                transition: background 0.2s;
            }
            .tmdb-item:hover {
                background: #374151;
            }
            .tmdb-item:last-child {
                border-bottom: none;
            }
            .tmdb-poster {
                width: 50px;
                height: 75px;
                object-fit: cover;
                border-radius: 4px;
                background: #111827;
            }
            .tmdb-info h4 {
                margin: 0 0 5px 0;
                font-size: 1.1rem;
            }
            .tmdb-info p {
                margin: 0;
                font-size: 0.85rem;
                color: #9ca3af;
            }
            .type-badge {
                display: inline-block;
                padding: 2px 6px;
                border-radius: 4px;
                font-size: 0.75rem;
                font-weight: bold;
                background: #00b4d8;
                color: white;
                margin-top: 5px;
            }
            .type-badge.tv {
                background: #8b5cf6;
            }
        </style>
    @endpush

    <div style="padding-top: 2rem;">
        <h2 class="text-center mb-4">Importar Nuevo Título vía TMDB</h2>

        <div class="tarjeta tmdb-search-container">
            <p class="text-center text-muted mb-4">Busca por el nombre de la película o serie y selecciónala en la lista para añadirla automáticamente a la base de datos.</p>

            <div class="campo-auth relative">
                <input type="text" id="tmdb_search" autocomplete="off" placeholder="Escribe el nombre de la película o serie..." style="padding: 12px; font-size: 1.1rem; width: 100%;">
                
                <div id="tmdb_loader" style="position: absolute; right: 15px; top: 15px; display: none;">
                    <span style="color: #00b4d8; font-size: 0.9rem;">Buscando...</span>
                </div>
            </div>

            <!-- Autocomplete Results -->
            <div class="tmdb-results" id="tmdb_results"></div>
            
            <div style="margin-top: 20px; text-align: center;">
                <a href="{{ route('admin.index') }}" class="boton text-muted" style="background: transparent; border: 1px solid #4b5563;">Cancelar y Volver</a>
            </div>
        </div>

        <!-- Formulario oculto que se envía al hacer clic en un resultado -->
        <form id="tmdb_form" action="{{ route('admin.contenidos.storeTmdb') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="tmdb_id" id="form_tmdb_id">
            <input type="hidden" name="tmdb_type" id="form_tmdb_type">
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('tmdb_search');
            const resultsContainer = document.getElementById('tmdb_results');
            const loader = document.getElementById('tmdb_loader');
            
            const form = document.getElementById('tmdb_form');
            const formId = document.getElementById('form_tmdb_id');
            const formType = document.getElementById('form_tmdb_type');

            let timeoutId;

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                clearTimeout(timeoutId);
                
                if (query.length < 3) {
                    resultsContainer.style.display = 'none';
                    return;
                }

                loader.style.display = 'block';

                // Usar debounce para no saturar la API
                timeoutId = setTimeout(() => {
                    fetch(`/admin/tmdb/search?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            loader.style.display = 'none';
                            renderResults(data);
                        })
                        .catch(err => {
                            console.error('Error fetching TMDB:', err);
                            loader.style.display = 'none';
                        });
                }, 500);
            });

            function renderResults(results) {
                if (!results || results.length === 0) {
                    resultsContainer.innerHTML = '<div style="padding: 15px; text-align: center; color: #9ca3af;">No se encontraron resultados.</div>';
                    resultsContainer.style.display = 'block';
                    return;
                }

                let html = '';
                results.forEach(item => {
                    const id = item.id;
                    const type = item.media_type; // 'movie' or 'tv'
                    const title = type === 'movie' ? item.title : item.name;
                    const date = type === 'movie' ? item.release_date : item.first_air_date;
                    const year = date ? date.substring(0, 4) : 'N/A';
                    const imgUrl = item.poster_path ? `https://image.tmdb.org/t/p/w92${item.poster_path}` : 'https://via.placeholder.com/92x138?text=No+Img';
                    const isMovie = type === 'movie';

                    html += `
                        <div class="tmdb-item" data-id="${id}" data-type="${type}">
                            <img src="${imgUrl}" class="tmdb-poster" alt="Poster">
                            <div class="tmdb-info">
                                <h4>${title} <span style="font-weight: normal; color: #9ca3af;">(${year})</span></h4>
                                <span class="type-badge ${isMovie ? 'movie' : 'tv'}">${isMovie ? 'Película' : 'Serie'}</span>
                            </div>
                        </div>
                    `;
                });

                resultsContainer.innerHTML = html;
                resultsContainer.style.display = 'block';

                // Añadir evento click
                document.querySelectorAll('.tmdb-item').forEach(el => {
                    el.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const type = this.getAttribute('data-type');
                        
                        // Rellenar formulario y enviar
                        formId.value = id;
                        formType.value = type;
                        
                        // Cambiar UI para dar feedback visual
                        searchInput.value = 'Importando... Por favor, espera.';
                        searchInput.disabled = true;
                        resultsContainer.style.display = 'none';
                        loader.style.display = 'block';
                        
                        form.submit();
                    });
                });
            }

            // Ocultar resultados si clicamos fuera
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.tmdb-search-container')) {
                    resultsContainer.style.display = 'none';
                }
            });
        });
    </script>
    @endpush
@endsection
