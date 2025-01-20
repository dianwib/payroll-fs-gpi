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
        Schema::create('employe_salaries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('employe_id');
            $table->ulid('salary_id');
            $table->numeric('basic_salary')->default(0);
            $table->numeric('meal_allowances')->default(0);
            $table->numeric('transport_allowances')->default(0);
            $table->numeric('position_allowances')->default(0);
            $table->boolean('is_using_master_salary')->default(true);
            $table->date('periode');
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employe_id')->references('id')->on('employes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('salary_id')->references('id')->on('salaries')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employe_salaries');
    }
};
