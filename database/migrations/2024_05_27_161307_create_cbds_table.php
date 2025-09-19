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
        Schema::create('cbds', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->string('revision_no')->nullable();
            $table->string('year')->nullable();
            $table->string('planning_ssn')->nullable();
            $table->string('global_business_unit')->nullable();
            $table->string('business_unit')->nullable();
            $table->string('item_brand')->nullable();
            $table->string('department')->nullable();
            $table->string('revised_date')->nullable();
            $table->string('document_status')->nullable();
            $table->string('answered_status')->nullable();
            $table->string('vendor_person_in_change')->nullable();
            $table->string('decision_date')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('contracted_etd')->nullable();
            $table->string('eta_wh')->nullable();
            $table->string('approver')->nullable();
            $table->string('approval_date')->nullable();
            $table->string('order_condition')->nullable();
            $table->string('remark')->nullable();
            $table->string('raw_material_code')->nullable();
            $table->string('supplier_raw_material_code');
            $table->string('supplier_raw_material');
            $table->string('vendor_code')->nullable();
            $table->string('vendor')->nullable();
            $table->string('management_factory_code')->nullable();
            $table->string('management_factory')->nullable();
            $table->string('branch_factory_code')->nullable();
            $table->string('branch_factory')->nullable();
            $table->string('order_plan_number')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item');
            $table->string('representative_sample_code');  
            $table->string('sample_code');
            $table->string('contracted_etd2')->nullable();
            $table->string('eta_wh2')->nullable();                                                                         
            $table->string('remark2')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbds');
    }
};
