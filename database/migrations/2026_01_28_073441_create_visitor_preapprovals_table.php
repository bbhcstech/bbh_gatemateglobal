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
        Schema::create('visitor_preapprovals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('resident_id')->constrained()->cascadeOnDelete();
    $table->foreignId('visitor_id')->constrained()->cascadeOnDelete();
    $table->date('visit_date');
    $table->time('expected_time');
    $table->text('qr_code')->nullable();
    $table->enum('status', ['pending','approved','used','expired'])->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_preapprovals');
    }
};
