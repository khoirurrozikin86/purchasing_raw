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
        Schema::table('material_ins', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
        Schema::table('material_in_details', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
        Schema::table('material_outs', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
        Schema::table('material_out_details', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
        Schema::table('material_returns', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
        Schema::table('material_return_details', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
        Schema::table('purchase_request_details', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
        Schema::table('items', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_ins', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('material_in_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('material_outs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('material_out_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('material_returns', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('material_return_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('purchase_request_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

    }
};
