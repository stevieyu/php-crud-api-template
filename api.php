<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

//require file_exists('./vendor/autoload.php') ? 'vendor/autoload.php' : 'vendor.phar';
require_once './vendor/mevdschee/php-crud-api/api.include.php';
//require_once 'https://cdn.jsdelivr.net/gh/mevdschee/php-crud-api/api.include.php';

//if(!file_exists('api.include.php')) file_put_contents('api.include.php', file_get_contents('https://cdn.jsdelivr.net/gh/mevdschee/php-crud-api/api.include.php'));
//require_once 'api.include.php';

use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudApi\Config\Config;
use Tqdev\PhpCrudApi\Api;

$request_url = $_SERVER['REQUEST_URI'] ?? '';
if ($request_url === '/api/docs') {
    echo <<<EOT
<script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist/swagger-ui-bundle.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/swagger-ui-dist/swagger-ui.css">
<div id="swagger-ui"></div>
<script>
  const ui = SwaggerUIBundle({
    //url: "https://petstore.swagger.io/v2/swagger.json",
    url: '/api/openapi',
    dom_id: '#swagger-ui',
})
</script>
EOT;
    exit();
}
if(!$request_url){
    echo <<<EOT
首页
EOT;
    exit();
}

$config = new Config([
    'driver' => getenv('DB_DRIVER') ?: $_ENV['DB_DRIVER'] ?? 'sqlite',
    'address' => getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? 'database.db',
    'port' => getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? '3306',
    'username' => getenv('DB_USERNAME') ?: $_ENV['DB_USERNAME'] ?? 'root',
    'password' => getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'] ?? 'password',
    'database' => getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? 'test',
    'basePath' => '/api',
    'cacheTime' => 60,
    'debug' => true,
//    'cachePath' => __DIR__.'/.cache',
    'cachePath' => getenv('CACHE_PATH') ?: $_ENV['CACHE_PATH'] ?? '/tmp',
    'middlewares' => 'cors,errors,json,dbAuth,apiKeyDbAuth,authorization',

    'json.tables' => 'pages',
    'json.columns' => 'data',

    'apiKeyDbAuth.mode' => 'optional',

    'dbAuth.mode' => 'optional',
    'dbAuth.usersTable' => 'users',
    'dbAuth.usernameColumn' => 'phone',
    'dbAuth.passwordColumn' => 'api_token',

    'authorization.tableHandler' => function ($operation, $tableName) {
        return !preg_match('/^(users|order)/', $tableName);
    },

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

