<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('review');
            $table->timestamp('published_at');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
        });

        Schema::create('user_has_reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('review_id')->constrained()->onDelete('cascade');
            $table->primary(['user_id', 'review_id']);
        });

        Schema::create('advertisement_has_reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('advertisement_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('review_id')->constrained()->onDelete('cascade');
            $table->primary(['advertisement_id', 'review_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('user_has_reviews');
        Schema::dropIfExists('advertisement_has_reviews');
    }
};
