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
        return rtrim(implode(DIRECTORY_SEPARATOR, $argv), '/');
    }

    public static function filename($file)
    {
        $file = rtrim($file, DIRECTORY_SEPARATOR);
        $lastSlashPost = strpos($file, DIRECTORY_SEPARATOR);
        $firstPost = $lastSlashPost === false ? 0 : $lastSlashPost;
        return substr($file, $firstPost, strrpos($file, '.'));
    }

    public static function specify($arg1)
    {
        $path = static::join(func_get_args());
        $globs = glob("$path.*");

        if (count($globs) === 1) {
            return $globs[0];
        }

         foreach ($globs as $i => $file) {
             if ($file === "$path/.." || $file === "$path/.") {
                 unset($globs[$i]);
             }
         }

         if (count($globs)) {
             throw new \Exception("Ambiguously. Files with the same name, there is more than one: `$path`");
         }

        return false;
    }

    public static function back($path, $fail = '')
    {
        $lastSeparator = strrpos($path, DIRECTORY_SEPARATOR);
        if (is_integer($lastSeparator)) {
            return substr($path, 0, $lastSeparator);
        }

        return $fail;
    }

}