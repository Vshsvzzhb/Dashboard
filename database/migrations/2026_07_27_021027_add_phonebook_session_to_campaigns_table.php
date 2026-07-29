<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreignId('phonebook_id')->nullable()->constrained('phonebooks')->nullOnDelete()->after('id');
            $table->string('session')->nullable()->after('target_audience');
            $table->timestamp('sent_at')->nullable()->after('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropConstrainedForeignId('phonebook_id');
            $table->dropColumn(['session', 'sent_at']);
        });
    }
};
