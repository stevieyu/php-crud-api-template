<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

require file_exists('./vendor/autoload.php') ? 'vendor/autoload.php' : 'vendor.phar';

use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\Api;

$request_url = $_SERVER['REQUEST_URI'] ?? '';
if ($request_url === '/api/docs') {
    echo file_get_contents('./api-docs.html');
    return;
}

$config = new Config([
    'address' => getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? 'sdm723416260.my3w.com',
    'port' => getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? '3306',
    'username' => getenv('DB_USERNAME') ?: $_ENV['DB_USERNAME'] ?? 'sdm723416260',
    'password' => getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'] ?? 'QKW7e5YE',
    'database' => getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? 'sdm723416260_db',
    'basePath' => '/api',
    'cacheTime' => 1,
//    'cachePath' => __DIR__.'/.cache',
    'cachePath' => getenv('CACHE_PATH') ?: $_ENV['CACHE_PATH'] ?? '/tmp',
    'middlewares' => 'cors,errors,json',
    'json.tables' => 'pages',
    'json.columns' => 'data',
    'cors.allowedOrigins' => '*',
    'cors.allowHeaders' => 'X-Authorization,X-API-Key,Content-Type',
    'openApiBase' => json_encode([
        'info' => [
            'title' => 'PHP-CRUD-API',
            'version' => '1.0.0'
        ],
        'servers' => [
            [
                'url' => '//'.$_SERVER['HTTP_HOST']
            ]
        ]
    ]),
]);
$start_time = microtime(true);

$request = RequestFactory::fromGlobals();
$ui = new Api($config);
$response = $ui->handle($request);

$end_time = microtime(true);
$run_time = ($end_time - $start_time) * 1000;
header('Server-Timing: app;dur='.$run_time);

ResponseUtils::output($response);

