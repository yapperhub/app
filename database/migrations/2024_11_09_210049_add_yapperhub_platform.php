<?php

use App\Models\Platform;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Platform::query()->create([
            'name' => 'Yapper Hub',
            'slug' => 'yapper-hub',
            'description' => 'Yapper Hub is a platform for developers to share their blog posts on other platforms.',
            'url' => 'https://yapperhub.com',
            'logo' => 'https://yapperhub.com/img/yh-no-bg.png',
            'credentials' => null,
        ]);
    }

    public function down(): void
    {
        //
    }
};
