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
        Schema::create('purchase_request_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_request_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('qty');
            $table->string('consumtion')->nullable();
            $table->string('allowance')->nullable();
            $table->string('total');
            $table->string('status')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_details');
    }
};
