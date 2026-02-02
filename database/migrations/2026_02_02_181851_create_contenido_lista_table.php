<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenidoListaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenido_lista', function (Blueprint $table) {
            $table->id();

            // Conecta una Lista con una Película
            $table->foreignId('lista_id')->constrained('listas')->onDelete('cascade');
            $table->foreignId('contenido_id')->constrained('contenidos')->onDelete('cascade');

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
        Schema::dropIfExists('contenido_lista');
    }
}
