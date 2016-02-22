<?php

use welcome\collections\AryFilter;
use welcome\collections\enum\TypeEnum;
use welcome\collections\enum\FilterEnum;
use welcome\components\env\EnvManager;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require '../vendor/autoload.php';
require 'Site.php';

$r = new ReflectionClass(Site::class);
var_dump($r->getProperty('p33')->getModifiers());


die;
EnvManager::getInstance(['cachePath' => '../vendor']);