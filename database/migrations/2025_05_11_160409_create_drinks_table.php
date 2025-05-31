<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drinks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->json('prices'); // Store prices for different volumes as JSON
            $table->json('volumes'); // Store available volumes as JSON
            $table->boolean('is_hit')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_discount')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('drinks');
    }
};