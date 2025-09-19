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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string("item_code")->unique();
            $table->string("item_name");
            $table->string("description");
            $table->unsignedBigInteger("category_id"); // Assuming category_id is a foreign key
            $table->unsignedBigInteger("unit_id"); // Assuming unit_id is a foreign key
            $table->string("remark")->nullable();

            $table->timestamps();

                // Adding foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
