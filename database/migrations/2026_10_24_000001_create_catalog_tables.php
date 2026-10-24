<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->string('symbol', 20);
            $table->string('dimension', 30);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('catalog_items', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 160);
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('base_unit_id')->constrained('units')->restrictOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category_id', 'is_active']);
            $table->index(['base_unit_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_items');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('units');
    }
};
