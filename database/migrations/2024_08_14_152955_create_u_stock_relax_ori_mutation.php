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
        CREATE VIEW u_stock_relax_ori_mutation AS  
         WITH return_info AS (
    SELECT
        `id`,
        IF(
            EXISTS (
                SELECT 1
                FROM `db_timw`.`relax_return_details`
                WHERE `db_timw`.`relax_return_details`.`id` = `u_stock_relax_ori`.`id`
            ),
            ABS(`qty`),
            0
        ) AS `return_qty`
    FROM `db_timw`.`u_stock_relax_ori`
),
adjusted_stock AS (
    SELECT
        `u_stock_relax_ori`.`id` AS `id`,
        `u_stock_relax_ori`.`original_no` AS `original_no`,
        `u_stock_relax_ori`.`item_code` AS `item_code`,
        `u_stock_relax_ori`.`size` AS `size`,
        `u_stock_relax_ori`.`color_code` AS `color_code`,
        `u_stock_relax_ori`.`color_name` AS `color_name`,
        `u_stock_relax_ori`.`tanggal` AS `tanggal`,
        CASE
            WHEN return_info.`return_qty` > 0 THEN 0
            ELSE IF(`u_stock_relax_ori`.`qty` > 0, `u_stock_relax_ori`.`qty`, 0)
        END AS `in_qty`,
        IF(`u_stock_relax_ori`.`qty` < 0, -`u_stock_relax_ori`.`qty`, 0) AS `out_qty`,
        return_info.`return_qty` AS `return_qty`
    FROM
        `db_timw`.`u_stock_relax_ori`
    JOIN return_info ON `u_stock_relax_ori`.`id` = return_info.`id`
)
SELECT
    `adjusted_stock`.`id` AS `id`,
    `adjusted_stock`.`original_no` AS `original_no`,
    `adjusted_stock`.`item_code` AS `item_code`,
    `adjusted_stock`.`size` AS `size`,
    `adjusted_stock`.`color_code` AS `color_code`,
    `adjusted_stock`.`color_name` AS `color_name`,
    `adjusted_stock`.`tanggal` AS `tanggal`,
    `adjusted_stock`.`in_qty` AS `in_qty`,
    `adjusted_stock`.`out_qty` AS `out_qty`,
    `adjusted_stock`.`return_qty` AS `return_qty`,
    SUM(
        `adjusted_stock`.`in_qty` - `adjusted_stock`.`out_qty` + `adjusted_stock`.`return_qty`
    ) OVER(
        PARTITION BY
            `adjusted_stock`.`original_no`,
            `adjusted_stock`.`item_code`,
            `adjusted_stock`.`size`,
            `adjusted_stock`.`color_code`,
            `adjusted_stock`.`color_name`
        ORDER BY
            `adjusted_stock`.`tanggal`,
            `adjusted_stock`.`id`
        ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
    ) AS `balance`
FROM
    adjusted_stock

          
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
