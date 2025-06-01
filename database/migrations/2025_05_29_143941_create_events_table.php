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
            $table->date('date');
            $table->time('time');
            $table->string('event_type');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('event_for')->nullable();
            $table->text('event_guidelines')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_for')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
