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
        Schema::create('slip_digitals', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('employe_salary_id');
            $table->ulid('pph_id');
            $table->ulid('bpjs_id');
            $table->integer('overtime')->default(0);
            $table->integer('piece')->default(0);
            $table->integer('grand_total')->default(0);
            $table->integer('total')->default(0);
            $table->date('periode');
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employe_salary_id')->references('id')->on('employe_salaries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('pph_id')->references('id')->on('pphs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('bpjs_id')->references('id')->on('bpjs')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slip_digitals');
    }
};
