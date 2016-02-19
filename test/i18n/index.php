<?php

use welcome\components\i18n\Translator;
use welcome\components\i18n\FileSource;
use welcome\components\i18n\ChangeableFileSource;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require 'tests.php';

$originalFs = new FileSource('./original');
$cachedFs = new ChangeableFileSource('./cache/');
$t = new Translator($cachedFs, $originalFs);


itemInOut($t);
changesAliases($t);
commons($t);
switches($t);
changes($t);