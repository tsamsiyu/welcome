<?php namespace welcome\components\env;

use welcome\collections\AryFilter;
use welcome\collections\enum\FilterEnum;
use welcome\components\storage\Fs;
use welcome\components\storage\Io;
use welcome\collections\AryHelp;

class EnvManager
{
    const BY_DEFAULT = 'prod';

    protected $_originalPath;
    protected $_cachePath;
    protected $_map;
    protected $_current = self::BY_DEFAULT;
    private $_requiredKeys = [];
    private static $_instance;

    protected $_listeners = [];

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!isset(static::$_instance)) {
            $class = static::class;
            $argv = func_get_args();
            static::$_instance= new $class(reset($argv));
        }

        return static::$_instance;
    }

    public function __construct(array $config)
    {
        $this->_originalPath = AryFilter::pull($config, 'originalPath', ['filter' => FilterEnum::DIR]);
        $this->_cachePath = AryFilter::pullOrFail($config, 'cachePath', ['filter' => FilterEnum::DIR]);
        $this->readData();
    }

    public function readData()
    {
        if ($this->_originalPath) {
            foreach (new \DirectoryIterator($this->_originalPath) as $fileinfo) {
                if ($fileinfo->isFile()) {
                    $name = Fs::filename($fileinfo->getBasename());
                    $this->_map[$name] = Io::read($fileinfo->getPathname());
                }
            }
        }

        foreach (new \DirectoryIterator($this->_cachePath) as $fileinfo) {
            if ($fileinfo->isFile()) {
                $name = Fs::filename($fileinfo->getBasename());
                $this->_map[$name] = Io::read($fileinfo->getPathname());
            }
        }

        if (empty($this->_map)) {
            throw new \Exception('Could not find any environment config.');
        }

        return $this;
    }

    public function getList()
    {
        return array_keys($this->_map);
    }

    public function hasEnv($env)
    {
        return array_key_exists($env, $this->_map);
    }

    public function setCurrent($val)
    {
        if ($this->hasEnv($val)) {
            $this->_current = $val;
        }

        throw new \Exception('Environment is missing: ' . $val);
    }

    public function trigger()
    {
        foreach ($this->_listeners as $listener) {
            call_user_func_array($listener, func_get_args());
        }
    }

    public function listen($listener)
    {
        $this->_listeners[] = $listener;
    }

    public function required(array $keys)
    {
        $this->_requiredKeys = $keys;
        return $this;
    }

    public function check()
    {
        foreach ($this->_requiredKeys as $item) {
            $val = AryHelp::getBySegment($this->_map[$this->_current], $item);
            if ($val === null) {
                throw new \Exception('Such key required: ' . $item);
            }
        }

        return $this;
    }

    public function get($key)
    {
        return AryHelp::getBySegment($this->_map[$this->_current], $key);
    }

}