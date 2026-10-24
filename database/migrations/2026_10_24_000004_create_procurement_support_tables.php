<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_aliases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('catalog_item_id')->constrained()->restrictOnDelete();
            $table->string('alias', 160);
            $table->string('normalized_alias', 160);
            $table->string('raw_unit', 80)->nullable();
            $table->string('normalized_unit', 80)->nullable();
            $table->decimal('conversion_factor', 18, 6);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(
                ['supplier_id', 'normalized_alias', 'normalized_unit'],
                'item_alias_supplier_name_unit_unique',
            );
            $table->index(['normalized_alias', 'is_active']);
        });

        Schema::create('submission_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30);
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 30)->default('note');
            $table->text('body');
            $table->timestamp('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['due_at', 'completed_at']);
        });

        Schema::create('submission_supplier_link_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('to_supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('submission_item_mapping_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_catalog_item_id')->nullable()->constrained('catalog_items')->nullOnDelete();
            $table->foreignId('to_catalog_item_id')->nullable()->constrained('catalog_items')->nullOnDelete();
            $table->foreignId('from_unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('to_unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->decimal('conversion_factor', 18, 6)->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_item_mapping_histories');
        Schema::dropIfExists('submission_supplier_link_histories');
        Schema::dropIfExists('follow_ups');
        Schema::dropIfExists('submission_status_histories');
        Schema::dropIfExists('item_aliases');
    }
};
