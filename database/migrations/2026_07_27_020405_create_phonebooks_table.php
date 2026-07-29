<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phonebooks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->default('wa'); // wa / sms
            $table->timestamps();
        });

        // Tambah phonebook_id ke contacts
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreignId('phonebook_id')->nullable()->constrained('phonebooks')->nullOnDelete()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('phonebook_id');
        });
        Schema::dropIfExists('phonebooks');
    }
};
