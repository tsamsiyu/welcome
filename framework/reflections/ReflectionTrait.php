<?php namespace welcome\reflections;

/**
 * Class ReflectionTrait
 * @package welcome\traits
 */
trait ReflectionTrait
{
    public function getReflectionClass()
    {
        return ReflectionManager::getInstance(static::class);
    }
}