<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('platform_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('method');
            $table->string('url');
            $table->string('response_status_code');
            $table->string('response_time');
            $table->string('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->json('request');
            $table->json('response');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
