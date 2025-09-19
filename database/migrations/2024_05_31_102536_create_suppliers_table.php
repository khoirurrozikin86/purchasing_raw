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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code');
            $table->string('supplier_name');
            $table->string('supplier_npwp')->nullable();
            $table->string('supplier_fax')->nullable();
            $table->string('supplier_address');
            $table->string('supplier_city');
            $table->string('supplier_nation');
            $table->string('supplier_person');
            $table->string('supplier_phone')->nullable();
            $table->string('supplier_email')->nullable();
            $table->string('remark')->nullable(); ;
       
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
