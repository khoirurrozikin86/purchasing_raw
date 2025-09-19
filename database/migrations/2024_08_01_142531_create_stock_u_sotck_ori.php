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
        DB::statement("      
           CREATE VIEW u_stock_ori AS
        SELECT
            material_in_details.id AS id,
            material_in_details.created_at AS tanggal,
            material_in_details.original_no AS original_no,
            material_in_details.item_code AS item_code,
            material_in_details.size AS size,
            material_in_details.color_code AS color_code,
            material_in_details.color_name AS color_name,
            material_in_details.qty AS qty
        FROM
            material_in_details
        UNION ALL
        SELECT
            material_out_details.id AS id,
            material_out_details.created_at AS tanggal,
            material_out_details.original_no AS original_no,
            material_out_details.item_code AS item_code,
            material_out_details.size AS size,
            material_out_details.color_code AS color_code,
            material_out_details.color_name AS color_name,
            -material_out_details.qty AS qty
        FROM
            material_out_details
        UNION ALL
        SELECT
            material_return_details.id AS id,
            material_return_details.created_at AS tanggal,
            material_return_details.original_no AS original_no,
            material_return_details.item_code AS item_code,
            material_return_details.size AS size,
            material_return_details.color_code AS color_code,
            material_return_details.color_name AS color_name,
            material_return_details.qty AS qty
        FROM
            material_return_details;
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('stock_u_sotck_ori');
    }
};
