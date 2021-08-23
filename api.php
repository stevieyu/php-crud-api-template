<?php

namespace Tqdev\PhpCrudUi;

use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\Api;

require file_exists('./vendor.phar') ? './vendor.phar' : './vendor/autoload.php';

$request_url = $_SERVER['REQUEST_URI'] ?? '';
if ($request_url === '/api/docs') {
    echo file_get_contents('./api-docs.html');
    return;
}

$config = new Config([
    'address' => 'sdm688990573.my3w.com',
    'username' => 'sdm688990573',
    'password' => 'asAS12!@',
    'database' => 'sdm688990573_db',
    'basePath' => '/api',
    'cacheTime' => 1,
    'cachePath' => __DIR__.'.cache',
    'middlewares' => 'cors,errors,apiKeyDbAuth,authorization',
    'apiKeyDbAuth.mode' => 'optional',
    'authorization.tableHandler' => function($operation, $tableName) {
        return in_array($tableName, ['users', 'desig']);
    },
    'cors.allowedOrigins' => '*',
    'cors.allowHeaders' => 'X-Authorization,X-API-Key'
]);
$request = RequestFactory::fromGlobals();
$ui = new Api($config);
$response = $ui->handle($request);
ResponseUtils::output($response);