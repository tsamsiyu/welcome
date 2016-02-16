<?php namespace welcome\components\storage;

class Fs
{
    public static function join()
    {
        $argv = func_get_args();
        $first = reset($argv);
        if (is_array($first)) {
            return implode(DIRECTORY_SEPARATOR, $first);
        }
        return implode(DIRECTORY_SEPARATOR, $argv);
    }

    public static function parseFileName($file)
    {
        $file = rtrim($file, DIRECTORY_SEPARATOR);
        $lastSlashPost = strpos($file, DIRECTORY_SEPARATOR);
        $firstPost = $lastSlashPost === false ? 0 : $lastSlashPost;
        return substr($file, $firstPost, strrpos($file, '.'));
    }
}