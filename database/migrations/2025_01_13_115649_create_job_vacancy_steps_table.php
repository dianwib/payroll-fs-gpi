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
        Schema::create('job_vacancy_steps', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('job_vacancy_id');
            $table->ulid('job_step_id');
            $table->integer('number');
            $table->boolean('is_using_test')->default(false);
            $table->date('start_date')->default(null);
            $table->date('end_date')->default(null);
            $table->text('remarks')->default(null);
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('job_step_id')->references('id')->on('job_steps')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancy_steps');
    }
};
