<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('original_url');
            $table->string('slug', 100)->unique();
            $table->string('title', 150)->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->unsignedInteger('total_clicks')->default(0);
            $table->string('qr_code_path', 255)->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
