<?php
include 'init_autoloader.php';

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

class ExampleListenerAggregate extends AbstractListenerAggregate
{
	public function attach(EventManagerInterface $evm)
	{
		$evm->attach('foo', function () { echo 'Hello '; });
		$evm->attach('foo', function () { echo 'world'; });
	}
}
	
$evm = new Zend\EventManager\EventManager();
$evm->attachAggregate(new ExampleListenerAggregate(), 55);
$evm->trigger('foo');
