<?php

use welcome\collections\Tree;
use welcome\collections\enum\TypeEnum;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require '../vendor/autoload.php';


$c = new Tree([
    'a' => new TypeEnum(TypeEnum::BOOL),
    'b' => new TypeEnum(TypeEnum::CALLBACK)
]);