<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shelter_id')->constrained('shelters')->onDelete('cascade');
            $table->enum('type', ['cat', 'dog']);   
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('breed')->nullable();
            $table->string('description')->nullable();
            $table->integer('age')->nullable();
            $table->enum('status', ['available', 'adopted', 'pending'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
