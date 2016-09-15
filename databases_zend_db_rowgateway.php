<?php
// Q: Assuming a valid PDO connection, what class is echoed?
// A: (A) Zend\Db\ResultSet\ResultSet
//    (B) ArrayObject
//    (C) Zend\Db\Adapter\Driver\Pdo\Statement
//    (D) Zend\Db\RowGateway\RowGateway

include 'init_autoloader.php';

$adapter = new Zend\Db\Adapter\Adapter(include 'database_params.php');
$feature = new Zend\Db\TableGateway\Feature\RowGatewayFeature('sku');
$table   = new Zend\Db\TableGateway\TableGateway('products', $adapter, $feature);
$return  = $table->select(['sku' => '16751']);
foreach ($return as $result) Zend\Debug\Debug::dump($result);
$result->qty_oh = rand(1,999);
$result->save();
echo PHP_EOL;
