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
        Schema::create('q_r_codes', function (Blueprint $table) {
            $table->id();
            $table->string('original_no')->unique(); // Original No. harus unik
            $table->date('received_date')->nullable(); // Received Date
            $table->string('supplier_name')->nullable(); // Supplyer Name
            $table->string('item_code')->nullable(); // Fabric Code
            $table->string('po')->nullable(); // PO
            $table->string('color_code')->nullable(); // Color Code
            $table->string('color_name')->nullable(); // Color Name
            $table->string('batch')->nullable(); // Batch
            $table->integer('roll')->nullable(); // Roll
            $table->decimal('gross_weight', 8, 2)->nullable(); // G.W/.(kg)
            $table->decimal('net_weight', 8, 2)->nullable(); // N.W.(kg)
            $table->decimal('qty', 8, 2); // Packing List m
            $table->decimal('basic_width', 8, 2)->nullable(); // Basic Width
            $table->decimal('basic_grm', 8, 2)->nullable(); // Basic g/m2
            $table->string('mo')->nullable(); // mo
            $table->timestamps();


            $table->foreign('item_code')->references('item_code')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_r_codes');
    }
};
