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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();

            $table->date('expiration_date')->nullable();
            $table->string('location')->nullable();

            // Foreign Keys
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id'); // donor

            $table->string('status')->default('available');

            $table->timestamps();

            // FK constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
