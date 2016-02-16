<?php

use welcome\components\env\EnvManager;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require '../../vendor/autoload.php';



EnvManager::getInstance([
    'originalPath' => 'original',
    'cachePath' => 'cache'
])->required(['debug', 'env', 'testerEmail', 'db.dns', 'db.username', 'db.password'])->check();

var_dump(EnvManager::getInstance()->get('db.password'));