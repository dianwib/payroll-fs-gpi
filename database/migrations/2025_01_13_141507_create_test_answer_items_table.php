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
        Schema::create('test_answer_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('test_answer_id');
            $table->ulid('test_question_id');
            $table->ulid('test_question_answer_option_id')->nullable();
            $table->string('answer', 255)->nullable();
            $table->integer('value')->default(0);
            $table->text('remarks')->default(null);
            $table->boolean('is_active')->default(true);

            $table->ulid('created_by')->nullable();
            $table->ulid('updated_by')->nullable();
            $table->ulid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('test_question_id')->references('id')->on('test_questions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('test_question_answer_option_id')->references('id')->on('test_question_answer_options')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('test_answer_id')->references('id')->on('test_answers')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_answer_items');
    }
};
