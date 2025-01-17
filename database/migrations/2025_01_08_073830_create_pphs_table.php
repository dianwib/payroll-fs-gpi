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
        Schema::create('pphs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('employe_salary_id');
            $table->integer('pkp')->default(0);
            $table->integer('pajak_terutang')->default(0);
            $table->integer('tarif_pajak')->default(0);
            $table->date('periode');
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employe_salary_id')->references('id')->on('employe_salaries')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pphs');
    }
};
