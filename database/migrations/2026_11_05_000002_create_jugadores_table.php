<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('apellido');
            $table->unsignedSmallInteger('dorsal');
            $table->string('posicion');
            $table->decimal('altura', 3, 2)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['equipo_id', 'dorsal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jugadores');
    }
};
