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
        Schema::create('shipping_routes', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->timestamps();

            $table->foreignId('shipping_service_type_id')
                ->nullable()
                ->constrained('shipping_service_type')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_routes');
    }
};
