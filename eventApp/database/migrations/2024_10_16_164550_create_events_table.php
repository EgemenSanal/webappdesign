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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // name of the event
            $table->string('description'); // desc of the event
            $table->string('location'); // location of the event
            $table->string('starting_date')->nullable();
            $table->string('ending_date')->nullable();
            $table->integer('organizer_id'); // id of the organizer
            $table->integer('capacity')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
