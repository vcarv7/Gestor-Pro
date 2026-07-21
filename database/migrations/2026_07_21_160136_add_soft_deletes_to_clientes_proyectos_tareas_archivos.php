<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', fn (Blueprint $table) => $table->softDeletes());
        Schema::table('proyectos', fn (Blueprint $table) => $table->softDeletes());
        Schema::table('tareas', fn (Blueprint $table) => $table->softDeletes());
        Schema::table('archivos', fn (Blueprint $table) => $table->softDeletes());
    }

    public function down(): void
    {
        Schema::table('clientes', fn (Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('proyectos', fn (Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('tareas', fn (Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('archivos', fn (Blueprint $table) => $table->dropSoftDeletes());
    }
};
