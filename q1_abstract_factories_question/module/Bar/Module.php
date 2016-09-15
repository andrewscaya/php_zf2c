<?php
namespace Bar;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Foo\AbstractBazFactory;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return array(
            'service_manager' => array(
                'abstract_factories' => array(
                    'bar' => AbstractFooBarFactory::class,
                ),
            )
        );
    }

    public function getServiceConfig()
    {
        // this will cause a parse error
        //'abstract_factories' => array(
        //    'AbstractBazFactory'
        //),

        // this throws an exception because the return value *must* be an array!
        //array(
        //    'abstract_factories' => array(
        //        'AbstractBazFactory',
        //    ),
        //);

        // let's assume this, with its fully qualified class name:

        return array(
            'abstract_factories' => array(
                AbstractBazFactory::class,
            ),
        );
    }

}
