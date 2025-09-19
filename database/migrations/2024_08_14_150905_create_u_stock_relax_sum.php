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
        CREATE VIEW u_stock_relax_sum AS
        SELECT
            u_stock_relax.item_code AS item_code,
          
            u_stock_relax.size AS size,
            u_stock_relax.color_code AS color_code,
            u_stock_relax.color_name AS color_name,
              SUM(u_stock_relax.qty) AS stok
        FROM
            u_stock_relax
        GROUP BY
            u_stock_relax.item_code,
            u_stock_relax.size,
            u_stock_relax.color_code,
            u_stock_relax.color_name
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_stock_relax_sum');
    }
};
