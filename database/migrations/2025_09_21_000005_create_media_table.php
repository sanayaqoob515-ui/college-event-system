<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('file_type');
            $table->string('file_url');
            $table->string('caption')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('media'); }
}
