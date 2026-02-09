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
        Schema::create('category_user', function (Blueprint $table) {
            $table->id();
            // Links to your Users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Links to your Categories table
            // Note: we specify 'category_id' because you used a custom primary key
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_user');
    }
};
