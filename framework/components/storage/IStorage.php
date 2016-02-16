<?php namespace welcome\components\storage;

interface IStorage
{
    public function delete($path, array $options = null);

    public function write($fromPath, $toPath, array $options = null);

    public function read($path, array $options = null);

    public function rootPath();
}