<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nombre_original');
            $table->string('nombre_storage');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('tamano');
            $table->string('descripcion')->nullable();
            $table->timestamps();

            $table->index('proyecto_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
