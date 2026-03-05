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
        Schema::create('flats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('floor_id')->constrained()->onDelete('cascade');
    $table->string('flat_no'); // 1A, 1B, 2A
    $table->string('owner_name')->nullable();
    $table->string('status')->default('vacant'); // occupied / vacant
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
