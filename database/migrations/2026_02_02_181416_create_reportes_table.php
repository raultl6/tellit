<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->string('motivo'); // Ej: "Spoiler", "Insultos"
            $table->enum('estado', ['pendiente', 'revisado'])->default('pendiente');

            // Quién reporta
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Qué reseña se reporta
            $table->foreignId('resena_id')->constrained('resenas')->onDelete('cascade');

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
        Schema::dropIfExists('reportes');
    }
}
