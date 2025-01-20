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
        Schema::create('certificate_histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('employe_id')->nullable();
            $table->ulid('applicant_id')->nullable();
            $table->string('name', 255);
            $table->date('start_date')->default(null);
            $table->date('end_date')->default(null);
            $table->text('remarks')->default(null);
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employe_id')->references('id')->on('employes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('applicant_id')->references('id')->on('applicants')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_histories');
    }
};
