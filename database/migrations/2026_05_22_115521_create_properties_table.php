<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('property_type'); // House, Condo, Apartment, etc.
            $table->decimal('price', 15, 2);
            $table->integer('bedrooms');
            $table->decimal('bathrooms', 3, 1);
            $table->integer('floor_area');
            $table->integer('lot_area');
            $table->string('address');
            $table->string('city');
            $table->string('status')->default('available'); // available, reserved, sold
            $table->string('featured_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
