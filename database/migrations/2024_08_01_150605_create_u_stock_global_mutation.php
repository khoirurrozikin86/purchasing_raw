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
        DB::statement('
    CREATE VIEW u_stock_global_mutation AS 
            WITH return_info AS (
                SELECT
                    `id`,
                    ABS(`qty`) AS `return_qty`
                FROM
                    `material_return_details`
            )
            SELECT
                `u_stock_view`.`item_code` AS `item_code`,
                `u_stock_view`.`size` AS `size`,
                `u_stock_view`.`color_code` AS `color_code`,
                `u_stock_view`.`color_name` AS `color_name`,
                `u_stock_view`.`tanggal` AS `tanggal`,
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM return_info
                        WHERE return_info.`id` = `u_stock_view`.`id`
                    ) THEN 0
                    ELSE IF(`u_stock_view`.`qty` > 0, `u_stock_view`.`qty`, 0)
                END AS `in_qty`,
                IF(`u_stock_view`.`qty` < 0, -`u_stock_view`.`qty`, 0) AS `out_qty`,
                COALESCE((
                    SELECT return_qty
                    FROM return_info
                    WHERE return_info.`id` = `u_stock_view`.`id`
                ), 0) AS `return_qty`,
                SUM(
                    CASE
                        WHEN EXISTS (
                            SELECT 1
                            FROM return_info
                            WHERE return_info.`id` = `u_stock_view`.`id`
                        ) THEN 0
                        ELSE IF(`u_stock_view`.`qty` > 0, `u_stock_view`.`qty`, 0)
                    END
                    + COALESCE((
                        SELECT return_qty
                        FROM return_info
                        WHERE return_info.`id` = `u_stock_view`.`id`
                    ), 0)
                    - IF(`u_stock_view`.`qty` < 0, -`u_stock_view`.`qty`, 0)
                ) OVER(
                    PARTITION BY
                        `u_stock_view`.`item_code`,
                        `u_stock_view`.`size`,
                        `u_stock_view`.`color_code`,
                        `u_stock_view`.`color_name`
                    ORDER BY
                        `u_stock_view`.`tanggal`
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) AS `balance`
            FROM
                `u_stock_view`
        
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('u_stock_global_mutation');
    }
};
