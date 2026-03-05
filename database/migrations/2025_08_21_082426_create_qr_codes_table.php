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
        Schema::create('qr_codes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->string('name')->nullable();
        $table->string('category')->nullable(); // optional tag/group
        $table->string('type'); // url, text, wifi, map, whatsapp, pdf, audio, app
        $table->json('payload'); // normalized fields by type


        // style/options
        $table->string('format')->default('png'); // png|svg
        $table->unsignedSmallInteger('size')->default(512); // px box size
        $table->enum('error_correction', ['L','M','Q','H'])->default('M');
        $table->string('foreground')->default('#000000');
        $table->string('background')->default('#FFFFFF');
        $table->string('eye')->nullable(); // optional eye style (if you add)
        $table->string('logo_path')->nullable(); // stored logo overlay path


        // generated file
        $table->string('file_path')->nullable();
        $table->string('slug')->unique();
        $table->unsignedInteger('downloads')->default(0);


        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('qr_codes');
}
};
