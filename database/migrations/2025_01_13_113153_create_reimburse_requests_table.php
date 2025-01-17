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
        Schema::create('reimburse_requests', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('employe_id');
            $table->ulid('reimburse_type_id');
            $table->date('date')->default(null);
            $table->integer('amount')->default(0);
            $table->string('status', 255)->default(null);
            $table->text('remarks')->default(null);
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reimburse_type_id')->references('id')->on('reimburse_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('employe_id')->references('id')->on('employes')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimburse_requests');
    }
};
