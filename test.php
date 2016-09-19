<?php
// Q: Assuming a valid PDO connection, what class is returned?
// A: (A) Zend\Db\ResultSet\ResultSet
//    (B) ArrayObject
//    (C) Zend\Db\Adapter\Driver\Pdo\Statement
//    (D) None of the above

include 'init_autoloader.php';

$adapter = new Zend\Db\Adapter\Adapter(include 'database_params.php');
$return  = $adapter->query('SELECT * FROM products WHERE sku = ?', ['16751']);
foreach ($return as $item) {
	var_dump($item);
}
