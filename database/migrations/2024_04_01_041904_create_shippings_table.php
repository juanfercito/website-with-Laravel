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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('weight_cost', 8, 2)->nullable();
            $table->decimal('size_cost', 8, 2)->nullable();
            $table->decimal('total_cost', 8, 2);
            $table->string('estimated_delivery_time');
            $table->timestamps();

            $table->foreignId('shipping_service_type_id')
                ->nullable()
                ->constrained('shipping_service_types')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('shipping_route_id')
                ->nullable()
                ->constrained('shipping_routes')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
