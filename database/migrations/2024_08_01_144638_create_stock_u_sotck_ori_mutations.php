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
        CREATE VIEW u_stock_ori_mutation AS  
       WITH return_info AS (
    SELECT
        `u_stock_ori`.`id` AS `id`,
        ABS(`u_stock_ori`.`qty`) AS `return_qty`
    FROM
        `db_timw`.`material_return_details` AS `u_stock_ori`
),
adjusted_stock AS (
    SELECT
        `u_stock_ori`.`id` AS `id`,
        `u_stock_ori`.`original_no` AS `original_no`,
        `u_stock_ori`.`item_code` AS `item_code`,
        `u_stock_ori`.`size` AS `size`,
        `u_stock_ori`.`color_code` AS `color_code`,
        `u_stock_ori`.`color_name` AS `color_name`,
        `u_stock_ori`.`tanggal` AS `tanggal`,
        CASE
            WHEN `return_info`.`return_qty` IS NOT NULL THEN 0
            ELSE IF(`u_stock_ori`.`qty` > 0, `u_stock_ori`.`qty`, 0)
        END AS `in_qty`,
        CASE
            WHEN `return_info`.`return_qty` IS NOT NULL THEN 0
            ELSE IF(`u_stock_ori`.`qty` < 0, -`u_stock_ori`.`qty`, 0)
        END AS `out_qty`,
        COALESCE(`return_info`.`return_qty`, 0) AS `return_qty`
    FROM
        `db_timw`.`u_stock_ori`
    LEFT JOIN `return_info` ON `u_stock_ori`.`id` = `return_info`.`id`
),
-- Consolidating the transactions by date to avoid duplicates
consolidated AS (
    SELECT
        `original_no`,
        `item_code`,
        `size`,
        `color_code`,
        `color_name`,
        `tanggal`,
        SUM(`in_qty`) AS `total_in_qty`,
        SUM(`out_qty`) AS `total_out_qty`,
        SUM(`return_qty`) AS `total_return_qty`
    FROM
        `adjusted_stock`
    GROUP BY
        `original_no`, `item_code`, `size`, `color_code`, `color_name`, `tanggal`
)
SELECT
    `consolidated`.`original_no`,
    `consolidated`.`item_code`,
    `consolidated`.`size`,
    `consolidated`.`color_code`,
    `consolidated`.`color_name`,
    `consolidated`.`tanggal`,
    `consolidated`.`total_in_qty` AS `in_qty`,
    `consolidated`.`total_out_qty` AS `out_qty`,
    `consolidated`.`total_return_qty` AS `return_qty`,
    SUM(
        `consolidated`.`total_in_qty`
        - `consolidated`.`total_out_qty`
        + `consolidated`.`total_return_qty`
    ) OVER (
        PARTITION BY `consolidated`.`original_no`,
        `consolidated`.`item_code`,
        `consolidated`.`size`,
        `consolidated`.`color_code`,
        `consolidated`.`color_name`
        ORDER BY `consolidated`.`tanggal`, `consolidated`.`original_no` 
        ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
    ) AS `balance`
FROM
    `consolidated`
ORDER BY 
    `consolidated`.`original_no`,
    `consolidated`.`item_code`,
    `consolidated`.`size`,
    `consolidated`.`color_code`,
    `consolidated`.`color_name`,
    `consolidated`.`tanggal`;


          
          ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('stock_u_sotck_ori_mutations');
    }
};
