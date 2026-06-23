<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('links', function (Blueprint $table) {
            // Protected link: bcrypt hash of the access password (null = no password).
            $table->string('password')->nullable()->after('status');
            // Time-based link: optional active window (stored in UTC).
            $table->timestamp('starts_at')->nullable()->after('password');
            $table->timestamp('expires_at')->nullable()->after('starts_at');
        });
    }

    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn(['password', 'starts_at', 'expires_at']);
        });
    }
};
