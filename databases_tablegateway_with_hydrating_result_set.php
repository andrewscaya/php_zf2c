<?php
// Q: Assuming a valid PDO connection, what class is echoed?
// A: (A) Zend\Db\ResultSet\ResultSet
//    (B) ArrayObject
//    (C) Zend\Db\Adapter\Driver\Pdo\Statement
//    (D) Zend\Db\RowGateway\RowGateway

include 'init_autoloader.php';
include __DIR__ . '/Products.php';

$adapter = new Zend\Db\Adapter\Adapter(include 'database_params.php');
$result  = new Zend\Db\ResultSet\HydratingResultSet(new Zend\Stdlib\Hydrator\ObjectProperty(), new Products());
$table   = new Zend\Db\TableGateway\TableGateway('products', $adapter, NULL, $result);
$return  = $table->select(['sku' => '16751']);
foreach ($return as $result) {
	Zend\Debug\Debug::dump($result);
	echo PHP_EOL;
	echo get_class($result);
	echo PHP_EOL;
}
