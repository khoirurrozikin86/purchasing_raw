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
        Schema::create('material_in_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_in_id');
            $table->string('purchase_order_id')->nullable();
            $table->string('original_no')->nullable();
            $table->date('receive_date')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('item_code');
            $table->foreign('item_code')->references('item_code')->on('items')->onDelete('cascade'); // Foreign key reference
            $table->string('po')->nullable();
            $table->string('color_code')->nullable();
            $table->string('color_name')->nullable();
            $table->string('size')->nullable();
            $table->string('batch')->nullable();
            $table->integer('roll')->default(0);
            $table->decimal('gross_weight', 10, 2)->nullable();
            $table->decimal('net_weight', 10, 2)->nullable();
            $table->decimal('qty', 10, 2)->nullable();
            $table->decimal('basic_width', 10, 2)->nullable();
            $table->decimal('basic_grm', 10, 2)->nullable();
            $table->string('mo')->nullable();
            $table->decimal('actual_weight', 10, 2)->nullable();
            $table->string('rak')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

             // Adding foreign key constraints
             $table->foreign('material_in_id')->references('id')->on('material_ins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_in_details');
    }
};
