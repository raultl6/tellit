<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenidos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('descripcion');
            $table->string('imagen_url')->nullable();
            $table->integer('año');
            $table->enum('tipo', ['pelicula', 'serie']);
            $table->decimal('puntuacion', 3, 1)->default(0);

            // DATOS EXTRA DEL DISEÑO
            $table->string('director')->nullable();
            $table->string('duracion')->nullable(); // Ej: "2h 15m"
            $table->text('reparto')->nullable(); // Ej: "Keanu Reeves, Laurence Fishburne" (Texto simple para no complicarnos)

            // Relación con Categoría
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenidos');
    }
}
