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
        Schema::create('firewalls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturer_id')->onDelete('cascade');
            $table->foreignId('version_id')->onDelete('cascade');
            $table->string('firewall_ip')->nullable();
            $table->string('location')->nullable();
            $table->string('gateway')->nullable();
            $table->string('wan1')->nullable();
            $table->string('wan2')->nullable();
            $table->string('serial_number')->nullable();
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
        Schema::dropIfExists('firewalls');
    }
};
