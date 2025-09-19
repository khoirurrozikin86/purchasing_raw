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
       CREATE VIEW u_stock_mutation AS       
        SELECT
           item_code,
           size,
           color_code,
           color_name,
           tanggal,
           SUM(IF(qty > 0, qty, 0)) AS in_qty,
           SUM(IF(qty < 0, -qty, 0)) AS out_qty
        FROM
            u_stock_view
        GROUP BY 
           item_code,
           size,
           color_code,
           color_name,
           tanggal
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        DB::statement('DROP VIEW IF EXISTS u_stock_mutation');
    }
};
