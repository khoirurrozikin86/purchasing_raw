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
        Schema::create('material_return_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_return_id');
            $table->string('original_no');
            $table->string('item_code')->nullable();
            $table->foreign('item_code')->references('item_code')->on('items')->onDelete('cascade'); // Foreign key reference
            $table->string('color_code')->nullable();
            $table->string('color_name')->nullable();
            $table->string('size')->nullable();
            $table->decimal('qty', 10, 2)->nullable();
    
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('material_return_id')->references('id')->on('material_returns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_return_details');
    }
};
