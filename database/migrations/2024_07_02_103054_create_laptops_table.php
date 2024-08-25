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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();

            $table->foreignId('manufacturer_id')->onDelete('cascade');
            $table->foreignId('version_id')->onDelete('cascade');
            $table->string('processor_id')->nullable();
            $table->foreign('processor_id')->references('id')->on('processors')->onDelete('cascade')->nullable();
            $table->string('system_serial_number')->nullable();
            $table->boolean('is_assigned')
                ->default(0);
            $table->string('ram')->nullable();
            $table->string('memory_type')->nullable();
            $table->string('memory_size')->nullable();
            $table->timestamp('keyboard')->useCurrent();
            $table->timestamp('mouse')->useCurrent();
            $table->timestamp('unassigned_at')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_assets');
    }
};
