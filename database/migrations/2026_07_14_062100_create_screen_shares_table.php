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
        Schema::create('screen_rooms', function (Blueprint $class) {
            $class->id();
            $class->string('code')->unique();
            $class->string('host_id');
            $class->string('status')->default('active'); // active, inactive
            $class->string('mode')->default('webrtc'); // webrtc, frame
            $class->timestamps();
        });

        Schema::create('room_signals', function (Blueprint $class) {
            $class->id();
            $class->string('room_code');
            $class->string('sender_id');
            $class->string('recipient_id')->nullable(); // Can be host or specific viewer
            $class->string('type'); // offer, answer, candidate
            $class->text('payload'); // JSON string of WebRTC sdp/candidate
            $class->timestamps();

            $class->index('room_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_signals');
        Schema::dropIfExists('screen_rooms');
    }
};
