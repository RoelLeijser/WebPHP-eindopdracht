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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->date('end_date')->default(now()->addDays(7));
        });

        Schema::create('rented_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')->nullable()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('end_date');
        });

        Schema::dropIfExists('rented_products');
    }
};
