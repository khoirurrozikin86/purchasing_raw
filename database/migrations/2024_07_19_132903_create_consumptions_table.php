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
        Schema::create('consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cbd_detail_id')
            ->constrained('cbd_details') // Automatically sets up foreign key constraint
            ->onDelete('cascade'); // Optional: Deletes the consumption record if the related cbd_detail is deleted
            $table->string('width');
            $table->string('consumption');
            $table->string('remark');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumptions');
    }
};
