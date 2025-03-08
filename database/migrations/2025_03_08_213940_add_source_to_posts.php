<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('source')->nullable()->after('canonical_url')->default('web');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
