@extends('layouts.master')

@section('titulo', 'Importar desde TMDB')

@section('contenido')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endpush

    <div class="padding-admin">
        <h2 class="text-center mb-4">Importar Nuevo Título vía TMDB</h2>

        <div class="tarjeta tmdb-search-container">
            <p class="text-center text-gray mb-4">Busca por el nombre de la película o serie y selecciónala en la lista para añadirla automáticamente a la base de datos.</p>

            <div class="campo-auth relative">
                <input type="text" id="tmdb_search" autocomplete="off" placeholder="Escribe el nombre de la película o serie..." class="input-tmdb">
                
                <div id="tmdb_loader" class="loader-tmdb">
                    <span>Buscando...</span>
                </div>
            </div>

            <!-- Contenedor donde se muestran los resultados de la búsqueda -->
            <div class="tmdb-results" id="tmdb_results"></div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('admin.index') }}" class="boton boton-cancelar-tmdb text-gray">Cancelar y Volver</a>
            </div>
        </div>

        {{-- Formulario oculto que se rellena y envía automáticamente al seleccionar un resultado.
             Contiene el ID y el tipo (movie/tv) del título seleccionado --}}
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

            // Variable para controlar el debounce (retraso antes de buscar)
            let timeoutId;

            // Cada vez que el usuario escribe en el campo de búsqueda
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                // Se cancela la búsqueda anterior si el usuario sigue escribiendo
                clearTimeout(timeoutId);
                
                // No se busca hasta tener al menos 3 caracteres
                if (query.length < 3) {
                    resultsContainer.style.display = 'none';
                    return;
                }

                loader.style.display = 'block';

                // Debounce: se espera 500ms después de que el usuario deje de escribir antes de buscar.
                // Esto evita hacer demasiadas peticiones a la API mientras se está escribiendo
                timeoutId = setTimeout(() => {
                    // Se hace una petición al endpoint del servidor, que a su vez consulta la API de TMDB
                    // encodeURIComponent() codifica caracteres especiales para que la URL sea válida
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

            // Construye el HTML de los resultados y los inserta en la página
            function renderResults(results) {
                if (!results || results.length === 0) {
                    resultsContainer.innerHTML = '<div class="p-3 text-center text-gray">No se encontraron resultados.</div>';
                    resultsContainer.style.display = 'block';
                    return;
                }

                let html = '';
                results.forEach(item => {
                    const id = item.id;
                    const type = item.media_type;
                    // Las películas usan 'title' y las series usan 'name' en la respuesta de TMDB
                    const title = type === 'movie' ? item.title : item.name;
                    const date = type === 'movie' ? item.release_date : item.first_air_date;
                    const year = date ? date.substring(0, 4) : 'N/A';
                    // Se construye la URL del póster en tamaño pequeño (w92) para la lista de resultados
                    const imgUrl = item.poster_path ? `https://image.tmdb.org/t/p/w92${item.poster_path}` : 'https://via.placeholder.com/92x138?text=No+Img';
                    const isMovie = type === 'movie';

                    // Se genera el HTML de cada resultado con los atributos data- para almacenar el ID y tipo
                    html += `
                        <div class="tmdb-item" data-id="${id}" data-type="${type}">
                            <img src="${imgUrl}" class="tmdb-poster" alt="Poster">
                            <div class="tmdb-info">
                                <h4>${title} <span class="text-gray">(${year})</span></h4>
                                <span class="type-badge ${isMovie ? 'movie' : 'tv'}">${isMovie ? 'Película' : 'Serie'}</span>
                            </div>
                        </div>
                    `;
                });

                resultsContainer.innerHTML = html;
                resultsContainer.style.display = 'block';

                // Se asigna un evento de clic a cada resultado para importarlo
                document.querySelectorAll('.tmdb-item').forEach(el => {
                    el.addEventListener('click', function() {
                        // Se leen los datos del elemento seleccionado (almacenados en data-id y data-type)
                        const id = this.getAttribute('data-id');
                        const type = this.getAttribute('data-type');
                        
                        // Se rellenan los campos ocultos del formulario con los datos seleccionados
                        formId.value = id;
                        formType.value = type;
                        
                        // Se da feedback visual al usuario mientras se procesa la importación
                        searchInput.value = 'Importando... Por favor, espera.';
                        searchInput.disabled = true;
                        resultsContainer.style.display = 'none';
                        loader.style.display = 'block';
                        
                        // Se envía el formulario al servidor para procesar la importación
                        form.submit();
                    });
                });
            }

            // Se ocultan los resultados si el usuario hace clic fuera del contenedor de búsqueda
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.tmdb-search-container')) {
                    resultsContainer.style.display = 'none';
                }
            });
        });
    </script>
    @endpush
@endsection
