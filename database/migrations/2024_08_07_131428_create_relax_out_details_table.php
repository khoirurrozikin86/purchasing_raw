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
        Schema::create('relax_out_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('relax_out_id');
            $table->string('original_no');
            $table->string('item_code')->nullable();
            $table->foreign('item_code')->references('item_code')->on('items')->onDelete('cascade'); // Foreign key reference
            $table->string('color_code')->nullable();
            $table->string('color_name')->nullable();
            $table->string('size')->nullable();
        
            $table->string('mo')->nullable();
            $table->string('style')->nullable();
            $table->string('note')->nullable();
            $table->decimal('qty', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('relax_out_id')->references('id')->on('relax_outs')->onDelete('cascade');
            $table->foreign('original_no')->references('original_no')->on('material_in_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relax_out_details');
    }
};
