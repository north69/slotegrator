<?php
require dirname(__DIR__).'/config/bootstrap.php';

return [
    'paths' => [
        'migrations' => dirname(__DIR__).'/src/Migrations',
    ],
    'environments' => [
        'default_environment' => 'dev',
        'dev' => [
            'name' => $_ENV['MYSQL_DATABASE'],
            'dsn' => $_ENV['DATABASE_URL'],
        ]
    ]
];