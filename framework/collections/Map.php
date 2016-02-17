<?php namespace welcome\collections;

use welcome\collections\enum\TypeEnum;

class Map extends Collection
{
    public function __construct(array $container)
    {
        parent::__construct($container, TypeEnum::SCALAR);
    }
}