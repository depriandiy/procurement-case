<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->char('public_token', 26)->unique();
            $table->string('reference_no', 50)->unique();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained('supplier_contacts')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('submissions')->nullOnDelete();
            $table->unsignedInteger('revision_no')->default(1);
            $table->string('status', 30)->default('submitted');
            $table->timestamp('submitted_at')->useCurrent();
            $table->date('valid_until');
            $table->char('currency', 3)->default('IDR');
            $table->string('verification_code', 64);
            $table->char('client_token', 26)->unique();
            $table->string('supplier_name', 160);
            $table->string('supplier_tax_id', 40)->nullable();
            $table->text('supplier_address')->nullable();
            $table->string('contact_name', 160);
            $table->string('contact_email', 254)->nullable();
            $table->string('contact_phone', 40)->nullable();
            $table->timestamps();

            $table->index(['status', 'submitted_at']);
            $table->index(['supplier_id', 'submitted_at']);
        });

        Schema::create('submission_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('line_no');
            $table->foreignId('catalog_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('base_unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('raw_item_name', 160);
            $table->string('raw_unit', 80);
            $table->decimal('offered_price', 18, 4);
            $table->boolean('price_includes_tax')->default(false);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('conversion_factor', 18, 6)->nullable();
            $table->decimal('price_excl_tax', 18, 4)->nullable();
            $table->decimal('normalized_unit_price', 18, 6)->nullable();
            $table->decimal('moq', 18, 4)->nullable();
            $table->unsignedSmallInteger('lead_time_days')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['submission_id', 'line_no']);
            $table->index('catalog_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_items');
        Schema::dropIfExists('submissions');
    }
};
