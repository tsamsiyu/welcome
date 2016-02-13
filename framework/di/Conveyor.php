<?php namespace welcome\di;

use welcome\collections\AryHelper;
use welcome\collections\TypeEnum;
use welcome\Proxy;
use welcome\WObject;

class Conveyor extends WObject
{
    private $_singletons = [];
    private $_configs = [];


    public function get($id)
    {
        list($class, $config, $proxy, $options) = $this->_configs[$id];
        $obj = new $class;
        if ($proxy) {
            $obj = new Proxy($obj);
        }
        if (isset($options['afterCreate']) && is_callable($options['afterCreate'])) {
            call_user_func($options['afterCreate']);
        }
        foreach ($config as $key => $item) {
            $obj->$key = $item;
        }
        if (isset($options['afterInit']) && is_callable($options['afterInit'])) {
            call_user_func($options['afterInit']);
        }
        return $obj;
    }

    public function getSingleton($id)
    {
        if (!$this->hasSingleton($id)) {
            $obj = $this->get($id);
            $this->_singletons[$id] = $obj;
        }

        return $this->_singletons[$id];
    }

    public function hasSingleton($id)
    {
        return isset($this->_singletons[$id]);
    }

    public function set(array $config)
    {
        $class = AryHelper::required($config, '#scope', TypeEnum::STRING);
        $id = AryHelper::pull($config, '#id', $class);
        $lazy = AryHelper::pull($config, '#lazy', true);
        $proxy = AryHelper::pull($config, '#proxy', true);
        $afterCreate = AryHelper::pull($config, '#afterCreate');
        $afterInit = AryHelper::pull($config, '#afterInit');

        $this->_configs[$id] = [$class, $config, $proxy, [
            'afterCreate' => $afterCreate,
            'afterInit' => $afterInit
        ]];
        if (!$lazy) {
            $this->getSingleton($id);
        }

        return $this;
    }

    public function setSingleton($class, callable $creator, $id = null)
    {
        if (!$id) {
            $id = $class;
        }
        $res = $creator();
        if (is_subclass_of($res, $class)) {
            $this->_singletons[$id] = $res;
        }
        throw new \Exception("Callback must be return object of {$class} class");
    }

    public function __get($id)
    {
        return $this->getSingleton($id);
    }

/*    public function callMethod(object $obj, $method, array $arguments = [])
    {

    }

    public function callStatic($class, $method, array $arguments = [])
    {

    }

    public function callback(callable $func, array $arguments = [])
    {

    }*/

}