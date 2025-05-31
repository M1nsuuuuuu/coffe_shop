<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('drink_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Ensure a user can only favorite a drink once
            $table->unique(['user_id', 'drink_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};