<?php

namespace Tqdev\PhpCrudUi;

use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\Api;

require './vendor/autoload.php';
//require './vendor.phar';

$config = new Config([
    'address' => 'sdm688990573.my3w.com',
    'username' => 'sdm688990573',
    'password' => 'asAS12!@',
    'database' => 'sdm688990573_db',
    'basePath' => '/api',
    'cacheTime' => 0
]);
$request = RequestFactory::fromGlobals();
$ui = new Api($config);
$response = $ui->handle($request);
ResponseUtils::output($response);