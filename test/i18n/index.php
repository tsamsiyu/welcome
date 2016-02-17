<?php

use welcome\components\i18n\Translator;
use welcome\components\i18n\FileSource;
use welcome\components\i18n\ChangeableFileSource;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require '../../vendor/autoload.php';



$originalFs = new FileSource('./original');
$cachedFs = new ChangeableFileSource('./cache/');
$t = new Translator($cachedFs, $originalFs);

$t->setAlias('home');
$t->setAlias('errors', '@errors');
$t->useAlias('@errors');

var_dump($t->t('reclame.info.title'));
//var_dump($t->t('image.size_big', '@errors'));