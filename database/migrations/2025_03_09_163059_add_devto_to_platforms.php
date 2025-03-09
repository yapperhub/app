<?php

use App\Models\Platform;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Platform::query()->create([
            'name' => 'Dev',
            'slug' => 'dev-to',
            'description' => 'DEV is a community of software developers getting together to help one another out. The software industry relies on collaboration and networked learning. We provide a place for that to happen.',
            'url' => 'https://dev.to',
            'logo' => 'https://dev-to-uploads.s3.amazonaws.com/uploads/logos/resized_logo_UQww2soKuUsjaOGNB38o.png',
        ]);
    }

    public function down(): void
    {
        Schema::table('platforms', function (Blueprint $table) {
            //
        });
    }
};
