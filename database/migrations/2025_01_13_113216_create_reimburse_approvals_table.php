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
        Schema::create('reimburse_approvals', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('reimburse_request_id');
            $table->ulid('approved_by')->nullable();
            $table->string('status', 255)->default(null);
            $table->text('remarks')->default(null);
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reimburse_request_id')->references('id')->on('reimburse_requests')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimburse_approvals');
    }
};
