<?php
declare(strict_types=1);

require file_exists('./vendor/autoload.php') ? './vendor/autoload.php' : './vendor.phar';

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
    'address' => 'sdm723416260.my3w.com',
    'port' => '3306',
    'username' => 'sdm723416260',
    'password' => 'QKW7e5YE',
    'database' => 'sdm723416260_db',
    'basePath' => '/api',
    'cacheTime' => 1,
    'cachePath' => __DIR__.'/.cache',
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
ResponseUtils::output($response);

$end_time = microtime(true);
$run_time = ($end_time - $start_time) * 1000;
header('Server-Timing: app;dur='.$run_time);