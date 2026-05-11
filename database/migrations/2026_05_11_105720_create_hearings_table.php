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
        Schema::create('hearings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('legal_case_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('court')->nullable();

            $table->dateTime('hearing_date');

            $table->text('result')->nullable();

            $table->text('notes')->nullable();

            $table->string('status')->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hearings');
    }
};
