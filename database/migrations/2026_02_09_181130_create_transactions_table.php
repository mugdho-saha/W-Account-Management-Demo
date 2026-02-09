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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('description');

            // The "Double Entry" columns
            $table->foreignId('debit_category_id')->constrained('categories', 'category_id');
            $table->foreignId('credit_category_id')->constrained('categories', 'category_id');

            $table->decimal('amount', 15, 2);
            $table->foreignId('user_id')->constrained(); // The moderator who entered it
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
