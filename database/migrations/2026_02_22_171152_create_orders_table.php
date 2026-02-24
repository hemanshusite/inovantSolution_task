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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('order_unique_id')->unique();
            $table->string('order_number')->unique();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->decimal('subtotal', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('total_discount', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2)->default(0);
            $table->integer('total_items')->default(0);
            
            $table->enum('order_status', ['pending','processing','completed','cancelled','refunded','failed'])->default('pending');
            
            $table->enum('payment_status', ['pending','paid','failed','refunded'])->default('pending');
            
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();
            
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};