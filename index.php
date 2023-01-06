<?php

//$_ENV['DB_HOST'] = '127.0.0.1';
//$_ENV['DB_USERNAME'] = 'tx9z7gn';
//$_ENV['DB_PASSWORD'] = 'hgUS7O';
//$_ENV['DB_NAME'] = 'tx9z7gn';

//$_ENV['CACHE_PATH'] = __DIR__.'/.cache';

if(file_exists('./output/api.phar')){
    require_once 'output/api.phar';
} else
if(file_exists('./api.phar')){
    require_once 'api.phar';
} else
if(file_exists('./api.php')){
    require_once 'api.php';
} 

