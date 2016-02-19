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

$t->setAlias('home')
    ->setAlias('errors', '@errors')
    ->useAlias('@errors')
    ->setAlias('social.home', '@social.home')
;

//var_dump($t->t('reclame.info.title'));
//var_dump($t->t('image.size_big', '@errors'));
//var_dump($t->t('image.size_big'));
//var_dump($t->t('parameters.pretty', '@social.home'));
//var_dump($t->t('endless', '@social.home'));
//var_dump($t->t('endless'));

//var_dump($t->t('foo.bar'));
//var_dump($t->t('maroow.tree', '@social.home'));
//var_dump($t->t('maroow.tree', '@social.home'));
var_dump($t->t('maroow.tree'));
