<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('venue')->nullable();
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->integer('max_participants')->default(100);
            $table->integer('seats_booked')->default(0);
            $table->enum('status', ['pending','approved','cancelled'])->default('pending');
            $table->timestamps();

            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
