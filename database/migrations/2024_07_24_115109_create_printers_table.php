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
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturer_id')->onDelete('cascade');
            $table->foreignId('version_id')->onDelete('cascade');
            $table->string('printer_type')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('ink_code')->nullable();
            $table->string('maintenance_box')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_assigned')
                ->default(0);
            $table->timestamp('unassigned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
