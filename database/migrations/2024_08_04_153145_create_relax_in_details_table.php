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
        Schema::create('relax_in_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('relax_in_id');
            $table->string('original_no')->unique();
            $table->string('item_code')->nullable();
            $table->foreign('item_code')->references('item_code')->on('items')->onDelete('cascade');
            $table->string('color_code')->nullable();
            $table->string('color_name')->nullable();
            $table->string('size')->nullable();
            $table->decimal('qty', 10, 2)->nullable();
            $table->string('note')->nullable();
            $table->string('style')->nullable();
            $table->string('mo_number')->nullable();
            $table->string('fabric_pcs')->nullable();
            $table->string('inspec_machine_no')->nullable();
            $table->string('act_width_front')->nullable();
            $table->string('act_width_center')->nullable();
            $table->string('act_width_back')->nullable();
            $table->string('panjang_actual')->nullable();
            $table->string('hasil_fabric_ins')->nullable();
            $table->string('kotor')->nullable();
            $table->string('crease_mark')->nullable();
            $table->string('knot')->nullable();
            $table->string('hole')->nullable();
            $table->string('missing_yarn')->nullable();
            $table->string('foreign_yarn')->nullable();
            $table->string('benang_tebal')->nullable();
            $table->string('kontaminasi')->nullable();
            $table->string('shinning_others')->nullable();
            $table->string('maxim_ok_point')->nullable();
            $table->string('pass_ng')->nullable();
            $table->string('relaxing_rack_no')->nullable();
            $table->string('b_roll_rack_no')->nullable();
            $table->text('reason')->nullable();
            $table->string('selisih')->nullable();
            $table->string('sambungan_di_meter')->nullable();
            $table->timestamps();

            $table->foreign('relax_in_id')->references('id')->on('relax_ins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relax_in_details');
    }
};
