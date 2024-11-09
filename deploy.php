<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/yapperhub/app.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('146.190.32.125')
    ->set('remote_user', 'yapperhub')
    ->set('deploy_path', '~/htdocs/yapperhub.com');

desc('Build the assets');
task('build', function () {
    cd('{{release_path}}');
    run('npm install');
    run('npm run build');
});

task('optimize', function () {
    cd('{{release_path}}');
    run('php artisan optimize');
});

task('clear_cache', function () {
    cd('{{current_path}}');
    run('php artisan cache:clear');
});

after('deploy:update_code', 'build');
after('deploy:symlink', 'optimize');

// Hooks
after('deploy:failed', 'deploy:unlock');
