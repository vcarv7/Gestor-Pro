<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action', 20);              // 'create' | 'update' | 'delete'
            $table->string('subject_type', 100);       // 'App\Models\Cliente', etc.
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('subject_label', 255);      // snapshot del nombre al momento de la acción
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
