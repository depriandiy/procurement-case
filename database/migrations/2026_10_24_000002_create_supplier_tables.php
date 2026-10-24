<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->char('public_id', 26)->unique();
            $table->string('name', 160);
            $table->string('normalized_name', 160)->index();
            $table->string('tax_id', 40)->nullable();
            $table->string('normalized_tax_id', 40)->nullable()->unique();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('review_status', 30)->default('pending');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['review_status', 'is_active']);
        });

        Schema::create('supplier_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('name', 160);
            $table->string('email', 254)->nullable();
            $table->string('normalized_email', 254)->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('normalized_phone', 40)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['supplier_id', 'normalized_email']);
            $table->index(['supplier_id', 'is_active']);
            $table->index('normalized_phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_contacts');
        Schema::dropIfExists('suppliers');
    }
};
