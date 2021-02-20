<?php

namespace Tqdev\PhpCrudUi;

use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudUi\Config;
use Tqdev\PhpCrudUi\Ui;

require '../vendor/autoload.php';

$config = new Config([
    'api' => [
        'address' => 'sdm688990573.my3w.com',
        'username' => 'sdm688990573',
        'password' => 'asAS12!@',
        'database' => 'sdm688990573_db',
        'basePath' => '/api',
    ]
]);
$request = RequestFactory::fromGlobals();
$ui = new Ui($config);
$response = $ui->handle($request);
ResponseUtils::output($response);