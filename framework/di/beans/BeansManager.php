<?php namespace welcome\di\beans;

use welcome\collections\AryHelper;
use welcome\collections\enum\TypeEnum;
use welcome\WObject;

class BeansManager extends WObject
{
    private $_singletons = [];
    private $_configs = [];


    public function get($id)
    {
        list($class, $config) = $this->_configs[$id];
        $obj = new $class;
        /* @var IBeanable $obj */
        $obj->afterBeanCreate();
        foreach ($config as $key => $item) {
            $obj->$key = $item;
        }
        if (isset($options['afterInit']) && is_callable($options['afterInit'])) {
            call_user_func($options['afterInit']);
        }
        $obj->afterBeanInit();
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

    public function hasConfig($id)
    {
        return isset($this->_configs[$id]);
    }

    public function set(array $config)
    {
        $class = AryHelper::required($config, '#scope', TypeEnum::STRING);
        $id = AryHelper::pull($config, '#id', $class);
        $lazy = AryHelper::pull($config, '#lazy', true);

        $this->_configs[$id] = [$class, $config];
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

    public function addSingleton(IBeanable $bean, $id = null)
    {
        if (!$id) {
            $id = get_class($bean);
        }
        $this->_singletons[$id] = $bean;
    }

    public function __get($id)
    {
        return $this->getSingleton($id);
    }

}