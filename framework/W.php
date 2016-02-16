<?php namespace welcome;

use welcome\di\aspects\ProxyManager;
use welcome\di\beans\BeansManager;

class W
{
    private static $_beansManager;
    private static $_aspectsManager;

    private static $_config = [
        'beansManager' => BeansManager::class,
        'proxyManager' => ProxyManager::class
    ];

    public static function setConfig(array $config)
    {

    }

    public function setManagerConfig()
    {

    }

    /**
     * @return BeansManager
     */
    public static function getBeansManager()
    {
        if (!isset(static::$_beansManager)) {
            static::$_beansManager = new BeansManager();
        }

        return static::$_beansManager;
    }

    /**
     * @return ProxyManager
     */
    public static function getAspectManager()
    {
        if (!isset(static::$_aspectsManager)) {
            static::$_aspectsManager = new ProxyManager();
        }

        return static::$_aspectsManager;
    }

}