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
        Schema::create('consumption_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumption_id')->constrained()->onDelete('cascade');
            $table->string('type'); // e.g., 'body', 'piping', 'pocket', 'cuff', 'rib'
            $table->float('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumption_details');
    }
};
