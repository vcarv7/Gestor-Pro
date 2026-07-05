<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->boolean('dark_mode')->default(false);
            $table->boolean('notify_password_change')->default(true);
            $table->boolean('notify_cliente_delete')->default(true);
            $table->boolean('notify_proyecto_delete')->default(true);
            $table->boolean('notify_tarea_bulk_delete')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
