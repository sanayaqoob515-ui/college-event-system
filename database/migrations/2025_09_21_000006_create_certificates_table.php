<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
              $table->id();
              $table->unsignedBigInteger('event_id');
              $table->unsignedBigInteger('student_id');
              $table->string('certificate_url');
              $table->boolean('fee_paid')->default(false);
              $table->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('certificates'); }
}
