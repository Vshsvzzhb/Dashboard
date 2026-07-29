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
        Schema::create('webrtc_calls', function (Blueprint $table) {
            $table->id();
            $table->string('caller');
            $table->string('recipient');
            $table->string('duration')->default('00:00');
            $table->string('status')->default('Answered');
            $table->text('transcript')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webrtc_calls');
    }
};
