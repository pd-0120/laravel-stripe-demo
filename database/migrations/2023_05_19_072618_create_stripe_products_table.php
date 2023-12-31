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
        Schema::create('stripe_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('object');
            $table->boolean('active')->default(1);
            $table->double('default_price', 10,2)->default(0.00);
            $table->string('price_id');
            $table->string('interval')->default('yearly');
            $table->text('description')->nullable();
            $table->string('metadata')->nullable();
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_products');
    }
};
