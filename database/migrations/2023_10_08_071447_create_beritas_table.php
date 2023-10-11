<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false)->unique();
            $table->string('author');
            $table->string('deskripsi');
            $table->text('content')->nullable();
            $table->binary('foto')->nullable();
            $table->binary('foto1')->nullable();
            $table->binary('foto2')->nullable();
            $table->binary('foto3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};