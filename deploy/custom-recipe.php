<?php

namespace Deployer;

desc('Prepares a new release');
task('deploy:prepare', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'update_shared_files',
    'deploy:shared',
    'deploy:writable',
]);

desc('Deploys your project');
task('deploy', [
    'deploy:unlock',
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    //'artisan:config:cache',
    //'artisan:route:cache',
    'artisan:view:cache',
    'artisan:event:cache',
    'artisan:migrate',
    'npm:install',
    'npm:run:prod',
    'deploy:publish',
]);

desc('Clean release, remove unwanted files');
task('cleanup_release', function () {
    $filesToClean = [
        'node_modules/',
        '.env.example',
        '.gitattributes',
        '.gitignore',
        'deploy.yaml',
        'phpunit.xml',
        'tests/',
        'webpack.config.js',
        'webpack.mix.js',
        'vu.sh',
        'grumphp.yml',
        'docker-compose.yml',
        'README.md',
        'deploy',
        'REVISION',
        '.env.bkp',
    ];
    foreach ($filesToClean as $file) {
        run("cd {{release_path}} && rm -rf {{release_path}}/$file");
    }
    runLocally('rm -rf .env.bkp');
});

desc('Updates version number of the system');
task('update_version_number', function () {
    $output = runLocally("cd " . __DIR__ . "/../ && sh vu.sh");
    $matches = [];
    preg_match(
        '/([0-9]{2}-[0-9]{2}-[0-9]{4}\|\w{6,}|[vV]?[0-9]+\.[0-9]+\.[0-9]+)/',
        $output,
        $matches
    );
    $versionFounded = $matches[0];
    if (!$versionFounded) {
        writeln(" <info>Can't found a valid version number, skipping</info> ");
        return;
    }
    writeln(" <info>Founded version: {$versionFounded}</info> ");
    $sed = "cd {{deploy_path}}/current && sed -i 's/APP_VERSION=[a-zA-Z0-9\|\-\.]*$/APP_VERSION=$versionFounded/' .env";
    $output = run($sed);

    writeln(" <info>{$output}</info> ");
});

desc('Update shared files');
task('update_shared_files', function () {

    // In {deploy}/shared/storage/app location
    $foldersToUpdate = [
        'layers',
        'csv',
        'manuales'
    ];

    foreach ($foldersToUpdate as $folder) {
        run("cd {{deploy_path}}/shared/storage/app && rm -rf {{deploy_path}}/shared/storage/app/$folder");
        run("cp -r {{release_path}}/storage/app/$folder {{deploy_path}}/shared/storage/app");
    }
});
