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
        Schema::create('material_ins', function (Blueprint $table) {
            $table->id();
            $table->string('material_in_no');
            $table->unsignedBigInteger('supplier_id');
            $table->string('no_sj')->nullable();
            $table->string('received_by');
            $table->string('location')->nullable();
            $table->string('courier')->nullable();
            $table->string('remark')->nullable();
            $table->string('status')->nullable();
            
            $table->string('user_id');
         
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_ins');
    }
};
