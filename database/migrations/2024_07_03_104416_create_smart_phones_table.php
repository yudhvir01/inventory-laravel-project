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
        Schema::create('smart_phones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('manufacturer_id')->onDelete('cascade');
            $table->foreignId('version_id')->onDelete('cascade');
            $table->string('memory_size')->nullable();
            $table->string('ram')->nullable();
            $table->string('imei_number')->nullable();
            $table->string('is_assigned')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smart_phones');
    }
};
