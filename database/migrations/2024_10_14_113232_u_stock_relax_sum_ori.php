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
        CREATE VIEW `db_timw`.`u_stock_relax_sum_ori` AS
        SELECT
            combined.item_code AS item_code,
            combined.original_no AS original_no,
            combined.size AS size,
            combined.color_code AS color_code,
            combined.color_name AS color_name,
            SUM(combined.qty) AS stok
        FROM
            (
                SELECT
                    `relax_in_details`.`item_code` AS `item_code`,
                    `relax_in_details`.`original_no` AS `original_no`,
                    `relax_in_details`.`size` AS `size`,
                    `relax_in_details`.`color_code` AS `color_code`,
                    `relax_in_details`.`color_name` AS `color_name`,
                    `relax_in_details`.`qty` AS `qty`
                FROM
                    `db_timw`.`relax_in_details`
                
                UNION ALL
                
                SELECT
                    `relax_out_details`.`item_code` AS `item_code`,
                    `relax_out_details`.`original_no` AS `original_no`,
                    `relax_out_details`.`size` AS `size`,
                    `relax_out_details`.`color_code` AS `color_code`,
                    `relax_out_details`.`color_name` AS `color_name`,
                    -`relax_out_details`.`qty` AS `qty`
                FROM
                    `db_timw`.`relax_out_details`
                
                UNION ALL
                
                SELECT
                    `relax_return_details`.`item_code` AS `item_code`,
                    `relax_return_details`.`original_no` AS `original_no`,
                    `relax_return_details`.`size` AS `size`,
                    `relax_return_details`.`color_code` AS `color_code`,
                    `relax_return_details`.`color_name` AS `color_name`,
                    `relax_return_details`.`qty` AS `qty`
                FROM
                    `db_timw`.`relax_return_details`
            ) AS combined
        GROUP BY
            combined.item_code,
            combined.original_no,
            combined.size,
            combined.color_code,
            combined.color_name
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `db_timw`.`u_stock_relax_sum_ori`");
    }
};
