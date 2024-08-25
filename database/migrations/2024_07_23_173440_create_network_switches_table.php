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
        Schema::create('network_switches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturer_id')->onDelete('cascade');
            $table->foreignId('version_id')->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->string('service_tag')->nullable();
            $table->string('switch_type')->nullable();
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
        Schema::dropIfExists('n_v_r_s');
    }
};
