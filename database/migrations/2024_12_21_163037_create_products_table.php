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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->integer('price')->default(0);
            $table->integer('qty')->default(0);
            $table->string('description')->nullable();
            $table->boolean('status')->default(true);
            $table->tinyText('image')->nullable();
            $table->date('expired')->nullable();
            $table->foreignId('categoryId')->constrained('categories');
            $table->foreignId('unitId')->constrained('units');
            $table->foreignId('userId')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
