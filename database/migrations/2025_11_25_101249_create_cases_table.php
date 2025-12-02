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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assigned_to')->nullable();

            // Form fields
            $table->string('loan_id')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->decimal('amount', 15, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->string('loan_agreement')->nullable();
            $table->string('phone', 20)->nullable();

            // Existing optional fields
            $table->enum('category', ['credit_card','vehicale','life_insurance','agriculture'])->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->decimal('loan_amount', 15, 2)->nullable();
            $table->decimal('recovered_loan_amount', 15, 2)->nullable();
            $table->string('file')->nullable();

            $table->enum('status', ['pending', 'in-progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index(['status', 'assigned_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
