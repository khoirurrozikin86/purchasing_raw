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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_request_no');
            $table->unsignedBigInteger('cbd_id')->nullable();
             $table->string('tipe');
             $table->string('mo')->nullable();
             $table->string('style')->nullable();
             $table->string('destination')->nullable();
             $table->string('department');
             $table->string('applicant');
             $table->string('time_line')->nullable();
             $table->string('remark1')->nullable();
             $table->string('status')->nullable();
             $table->string('user_id');
             $table->unsignedInteger('revision_no')->default(0);

            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
