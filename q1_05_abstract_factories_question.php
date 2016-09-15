<?php
// how many abstract factories would be registered?
// technically NONE because as the code was written there would be a parse error
// see the ZendSkeletonBased app under "q1_abstract_factories_question"

include 'init_autoloader.php';

use Zend\ModuleManager\Listener\ConfigListener;

class NewConfig extends ConfigListener
{
	public $configs = array();
	public $paths   = array();
	public function addConfig($key, $config)
	{
		return parent::addConfig($key, $config);
	}
}

class Foo
{
	public function getConfig()
	{
		return array('service_manager' => array(
			'abstract_factories' => array(
				'foo' => 'AbstractFooBarFactory',
			),
		));
	}
	
	public function getServiceConfig()
	{
		return array(
			'abstract_factories' => array(
				'AbstractBazFactory',
			),
		);
	}
}

class Bar
{
	public function getConfig()
	{
		return array('service_manager' => array(
			'abstract_factories' => array(
				'bar' => 'AbstractFooBarFactory',
			),
		));
	}
	
	public function getServiceConfig()
	{
        // on the exam question there was 
        // no "return" and no "array()"
        // this would cause a parse error
        // SO ... let's assume this:
		return array(
			'abstract_factories' => array(
				'AbstractBazFactory',
			),
		);
	}
}

$foo = new Foo();
$bar = new Bar();
$configListener = new NewConfig();
$configListener->addConfig(1, $foo->getConfig()['service_manager']);
$configListener->addConfig(2, $foo->getServiceConfig());
$configListener->addConfig(3, $bar->getConfig()['service_manager']);
$configListener->addConfig(4, $bar->getServiceConfig());
$configListener->onMergeConfig(new Zend\ModuleManager\ModuleEvent);
//var_dump($configListener->getMergedConfig()->toArray());
var_dump($configListener);




