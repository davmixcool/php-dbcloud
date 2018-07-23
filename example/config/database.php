<?php

return [
    'mysql' => [
        'type' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'pass' => 'password',
        'database' => 'test',
        'singleTransaction' => false
    ],
    'postgres' => [
        'type' => 'postgresql',
        'host' => 'localhost',
        'port' => '5432',
        'user' => 'postgres',
        'pass' => 'password',
        'database' => 'test',
    ],
];
