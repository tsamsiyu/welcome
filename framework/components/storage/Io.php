<?php namespace welcome\components\storage;

class Io
{
    private static $_parsers = [
        'json' => JsonParser::class,
        'yml' => YamlParser::class
    ];

    public static function registerParser($class, $ext)
    {
        if (!is_subclass_of($class, IParser::class)) {
            throw new \Exception('Parser must me implement `IParser` interface');
        }
        static::$_parsers[$ext] = $class;
    }

    public static function encode($content, $ext)
    {
        /* @var IParser $parser - namespace of parser */
        $parser = static::$_parsers[$ext];
        return $parser::encode($content);
    }

    public static function decode($content, $ext)
    {
        /* @var IParser $parser - namespace of parser */
        $parser = static::$_parsers[$ext];
        return $parser::decode($content);
    }

    public static function hasParser($ext)
    {
        return array_key_exists($ext, static::$_parsers);
    }

    public static function read($path, $isParse = true)
    {
        $content = file_get_contents($path);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext === 'php') {
            return require $path;
        }
        if ($isParse) {
            if (static::hasParser($ext)) {
                return static::decode($content, $ext);
            }
            throw new \Exception("Parser is not exist for next type: `$ext`");
        }
        return $content;
    }

    public static function write($content, $path, $isParse = true)
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($isParse) {
            if (!static::hasParser($ext)) {
                throw new \Exception("Parser is not exist for next type: `$ext`");
            }
            $content = static::encode($content, $ext);
        }
        return file_put_contents($path, $content);
    }
}