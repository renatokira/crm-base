<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {

        Schema::create('matrices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('threshold')->nullable();
            $table->integer('bandwidth')->nullable();
            $table->string('unit')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matrices');
    }
};
