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
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('invoice_id');
            $table->integer('quantity');
            $table->double('unit_price');
            $table->foreign('product_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
                ->references('id')
                ->on('products');
            $table->foreign('invoice_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->references('id')
                ->on('invoices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products');
    }
};
