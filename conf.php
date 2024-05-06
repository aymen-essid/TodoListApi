<?php
#Database
define('DB_SERVER', 'mysql-db');
define('DB_SERVER_PORT', '3306');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'todoapi');

#Api
define('API_KEY', 'xxxxxxxxxxxxxxxxxxxxx');

# Define Routes
$defaultHomeRoute = '/home/index';

$routesConf = [
    '/',
    '/home/index',
    '/home/action',
    '/api/index',
    '/api/list/task',
    '/api/create/task',
    '/api/update/task',
    '/api/delete/task',
    '/security/login/user',
    '/security/logout/user',

    // Add more routes
];