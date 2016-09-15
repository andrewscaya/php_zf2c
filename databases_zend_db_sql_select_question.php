<?php
include 'init_autoloader.php';

$sql = new Zend\Db\Sql\Select('tablename');
$sql->where(new Zend\Db\Sql\Predicate\In('tablename.foo',[1, 2]));
var_dump($sql->getSqlString());
