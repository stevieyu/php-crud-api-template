<?php

date_default_timezone_set('PRC');

//$_ENV['DB_DRIVER'] = 'mysql';
//$_ENV['DB_HOST'] = '127.0.0.1';
//$_ENV['DB_USERNAME'] = 'tx9z7gn';
//$_ENV['DB_PASSWORD'] = 'hgUS7O';
//$_ENV['DB_NAME'] = 'tx9z7gn';

//$_ENV['CACHE_PATH'] = __DIR__.'/.cache';

if(file_exists('./api.phar')){
    require 'api.phar';
} else
if(file_exists('./api.php')){
    require 'api.php';
}
