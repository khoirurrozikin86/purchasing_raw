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
        Schema::create('material_returns', function (Blueprint $table) {
            $table->id();
            $table->string('material_return_no');
            $table->string('department')->nullable();
            $table->string('person')->nullable();
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
        Schema::dropIfExists('material_returns');
    }
};
