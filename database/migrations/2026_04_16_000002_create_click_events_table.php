<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('click_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained()->onDelete('cascade');
            $table->dateTime('clicked_at');
            $table->text('referrer')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('device_type', 50)->nullable();
            $table->string('ip_hash', 255)->nullable();
            $table->string('country', 100)->nullable();
            $table->dateTime('created_at')->useCurrent();

            $table->index('link_id');
            $table->index('clicked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('click_events');
    }
};
