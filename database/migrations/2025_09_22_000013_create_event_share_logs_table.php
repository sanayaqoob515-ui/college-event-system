<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_share_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('platform');
            $table->text('share_message')->nullable();
            $table->dateTime('share_timestamp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_share_logs');
    }
};
