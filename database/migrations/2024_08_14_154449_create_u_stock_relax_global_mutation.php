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
    CREATE VIEW u_stock_relax_global_mutation AS 
            WITH return_info AS (
                SELECT
                    `id`,
                    ABS(`qty`) AS `return_qty`
                FROM
                    `material_return_details`
            )
            SELECT
                `u_stock_relax`.`item_code` AS `item_code`,
                `u_stock_relax`.`size` AS `size`,
                `u_stock_relax`.`color_code` AS `color_code`,
                `u_stock_relax`.`color_name` AS `color_name`,
                `u_stock_relax`.`tanggal` AS `tanggal`,
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM return_info
                        WHERE return_info.`id` = `u_stock_relax`.`id`
                    ) THEN 0
                    ELSE IF(`u_stock_relax`.`qty` > 0, `u_stock_relax`.`qty`, 0)
                END AS `in_qty`,
                IF(`u_stock_relax`.`qty` < 0, -`u_stock_relax`.`qty`, 0) AS `out_qty`,
                COALESCE((
                    SELECT return_qty
                    FROM return_info
                    WHERE return_info.`id` = `u_stock_relax`.`id`
                ), 0) AS `return_qty`,
                SUM(
                    CASE
                        WHEN EXISTS (
                            SELECT 1
                            FROM return_info
                            WHERE return_info.`id` = `u_stock_relax`.`id`
                        ) THEN 0
                        ELSE IF(`u_stock_relax`.`qty` > 0, `u_stock_relax`.`qty`, 0)
                    END
                    + COALESCE((
                        SELECT return_qty
                        FROM return_info
                        WHERE return_info.`id` = `u_stock_relax`.`id`
                    ), 0)
                    - IF(`u_stock_relax`.`qty` < 0, -`u_stock_relax`.`qty`, 0)
                ) OVER(
                    PARTITION BY
                        `u_stock_relax`.`item_code`,
                        `u_stock_relax`.`size`,
                        `u_stock_relax`.`color_code`,
                        `u_stock_relax`.`color_name`
                    ORDER BY
                        `u_stock_relax`.`tanggal`
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) AS `balance`
            FROM
                `u_stock_relax`
        
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('u_stock_relax_global_mutation');
    }
};
