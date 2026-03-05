<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->string('vehicle_number')->unique();
            $table->string('sticker_number')->nullable();

            $table->string('vehicle_type'); // Car / Bike
            $table->string('make');
            $table->string('model');
            $table->string('color');

            $table->string('parking_slot')->nullable();

            $table->foreignId('resident_id')
                  ->constrained('residents')
                  ->cascadeOnDelete();

            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
