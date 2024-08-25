<?php

use App\Models\Manufacturer;
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
        Schema::create('c_p_u_s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('manufacturer_id')->onDelete('cascade');
            $table->foreignId('version_id')->onDelete('cascade');
            $table->string('processor_id')->nullable();
            $table->foreign('processor_id')->references('id')->on('processors')->onDelete('cascade')->nullable();
            $table->string('system_serial_number')->nullable();
            $table->string('ram')->nullable();
            $table->string('memory_type')->nullable();
            $table->string('memory_size')->nullable();
            $table->boolean('is_assigned')
                ->default(0);
            $table->timestamp('unassigned_at')->nullable();
            $table->string('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_p_u_s');
    }
};
