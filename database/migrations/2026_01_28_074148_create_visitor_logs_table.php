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
        Schema::create('visitor_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('visitor_id')->constrained()->cascadeOnDelete();
    $table->foreignId('resident_id')->constrained()->cascadeOnDelete();
    $table->dateTime('entry_time')->nullable();
    $table->dateTime('exit_time')->nullable();
    $table->string('verified_by')->nullable(); // guard name
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
