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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('number');
            $table->date('date');
            $table->date('due_date');
            $table->text('term_and_conditions');
            $table->double('discount');
            $table->double('total');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate()
                ->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
