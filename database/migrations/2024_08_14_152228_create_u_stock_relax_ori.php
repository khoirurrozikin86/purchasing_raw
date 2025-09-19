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
        CREATE VIEW u_stock_relax_ori AS
       SELECT
            relax_in_details.id AS id,
            relax_in_details.created_at AS tanggal,
            relax_in_details.original_no AS original_no,
            relax_in_details.item_code AS item_code,
            relax_in_details.size AS size,
            relax_in_details.color_code AS color_code,
            relax_in_details.color_name AS color_name,
            relax_in_details.qty AS qty
        FROM
            relax_in_details
        UNION ALL
        SELECT
            relax_out_details.id AS id,
            relax_out_details.created_at AS tanggal,
            relax_out_details.original_no AS original_no,
            relax_out_details.item_code AS item_code,
            relax_out_details.size AS size,
            relax_out_details.color_code AS color_code,
            relax_out_details.color_name AS color_name,
            - relax_out_details.qty AS qty
        FROM
            relax_out_details
        UNION ALL
        SELECT
            relax_return_details.id AS id,
            relax_return_details.created_at AS tanggal,
            relax_return_details.original_no AS original_no,
            relax_return_details.item_code AS item_code,
            relax_return_details.size AS size,
            relax_return_details.color_code AS color_code,
            relax_return_details.color_name AS color_name,
            relax_return_details.qty AS qty
        FROM
            relax_return_details;
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS u_stock_relax_ori');
    }
};
