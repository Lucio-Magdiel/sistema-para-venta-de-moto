<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motos', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->integer('año');
            $table->string('color');
            $table->integer('cilindrada');
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->enum('estado', ['nuevo', 'usado'])->default('nuevo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motos');
    }
};
