<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('proyecto_id')->constrained()->onDelete('cascade');
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
            $table->boolean('completada')->default(false);
            $table->timestamps();

            $table->index(['proyecto_id', 'completada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
