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
        Schema::create('blasts', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->json('recipients');        // array of phone numbers
            $table->integer('total')->default(0);
            $table->integer('sent')->default(0);
            $table->integer('failed')->default(0);
            $table->enum('status', ['queued', 'sending', 'done', 'failed'])->default('queued');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blasts');
    }
};
