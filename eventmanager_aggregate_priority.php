<?php
// what is the output of this code?
include 'init_autoloader.php';

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

class ExampleListenerAggregate extends AbstractListenerAggregate
{
	public function attach(EventManagerInterface $evm)
	{
		$evm->attach('foo', function () { echo 'Hello '; });
		$evm->attach('foo', function () { echo 'world'; }, 20);
	}
}
	
$evm = new Zend\EventManager\EventManager();
$evm->attach('foo', function ($e) { echo ' Maybe '; }, 10);
$evm->attachAggregate(new ExampleListenerAggregate(), 55);
$evm->trigger('foo');
