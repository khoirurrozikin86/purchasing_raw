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
        CREATE VIEW u_stock_original_sum AS
        SELECT
            u_stock_original_view.original_no AS original_no,
            u_stock_original_view.item_code AS item_code,
         
            u_stock_original_view.size AS size,
                u_stock_original_view.color_code AS color_code,
            u_stock_original_view.color_name AS color_name,
               SUM(u_stock_original_view.qty) AS stok
        FROM
            u_stock_original_view
        GROUP BY
            u_stock_original_view.original_no,
            u_stock_original_view.item_code,
            u_stock_original_view.size,
            u_stock_original_view.color_code,
              u_stock_original_view.color_name
    ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('u_stock_original_sum');
    }
};
