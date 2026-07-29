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
        Schema::table('blasts', function (Blueprint $table) {
            $table->string('type')->default('whatsapp')->after('status');      // whatsapp / sms
            $table->string('session')->nullable()->after('type');              // device session id
        });
    }

    public function down(): void
    {
        Schema::table('blasts', function (Blueprint $table) {
            $table->dropColumn(['type', 'session']);
        });
    }
};
