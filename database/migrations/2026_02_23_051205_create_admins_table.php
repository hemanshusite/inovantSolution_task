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
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->index('id');

            $table->string('name', 100);
            $table->string('phone_code', 5);
            $table->string('phone', 30);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->boolean('is_head')->default(0);

            $table->boolean('status')->default(1);
            $table->index('status');

            $table->integer('created_by');
            $table->integer('updated_by');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
