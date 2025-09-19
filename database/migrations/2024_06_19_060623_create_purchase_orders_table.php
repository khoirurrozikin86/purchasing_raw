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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_order_no');
            $table->bigInteger('purchase_request_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->string('date_in_house');
            $table->string('quotation_no')->nullable();
            $table->string('quotation_file')->nullable();
            $table->string('delivery_at');
            $table->string('terms');
            $table->string('payment');
            $table->string('ship_mode')->nullable();
            $table->string('applicant');
            $table->string('allocation');
            $table->string('approval');
            $table->string('subtotal');
            $table->string('rounding')->nullable();
            $table->string('discount')->nullable();
            $table->string('vat')->nullable();
            $table->string('vat_amount')->nullable();
            $table->string('grand_total');
            $table->string('purchase_amount');
            $table->longText('note1')->nullable();
            $table->longText('note2')->nullable();
            $table->longText('rule')->nullable();
            $table->string('status')->nullable();
            $table->string('remarksx')->nullable();
            $table->integer('user_id')->unsigned();
            $table->unsignedInteger('revision_no')->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
