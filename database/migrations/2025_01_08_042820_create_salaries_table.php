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
        Schema::create('salaries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('department_id');
            $table->ulid('role_id');
            $table->numeric('basic_salary')->default(0);
            $table->numeric('meal_allowances')->default(0);
            $table->numeric('transport_allowances')->default(0);
            $table->numeric('position_allowances')->default(0);
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
