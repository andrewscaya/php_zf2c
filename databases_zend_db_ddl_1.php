<?php
// NOTE: works thanks to Andrew C.

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Ddl\Column\Integer;
use Zend\Db\Sql\Ddl\Constraint\ForeignKey;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Db\Sql\Ddl\AlterTable;
use Zend\Db\Sql\Ddl\DropTable;
use Zend\Db\Sql\Ddl\Constraint\PrimaryKey;
use Zend\Debug\Debug;

include 'init_autoloader.php';
require 'lib' . DIRECTORY_SEPARATOR . 'databases_zend_db_ddl_1_include.php';

$tableNames = ['tmptype', 'products'];
$columnNames = ['id', 'name', 'tmptype_id'];

$adapter = new Zend\Db\Adapter\Adapter(include 'database_params.php');
$sql = new Zend\Db\Sql\Sql($adapter);
Debug::dump($adapter->getDriver()->getConnection());

$select = $sql->select('tablename');
$select->where(new Zend\Db\Sql\Predicate\In('tablename.foo', [1, 2]));
echo PHP_EOL . '<br />' . $sql->getSqlStringForSqlObject($select, $adapter->getPlatform()) . '<br />' . PHP_EOL;

// check if tables exist and, if not, create them
$tableTmptype = new TableGateway($tableNames[0], $adapter);

$sqlString = 'SHOW TABLES';
$result = $tableTmptype->getAdapter()->query($sqlString)->execute();

$newTables = getStructuresToBeCreated($tableNames, $result);

if (!empty($newTables)) {

    foreach ($newTables as $table) {

        $tableDdl = new CreateTable($table, false);
        $tableDdl->addColumn(new Integer('id'));
        $tableDdl->addConstraint(new PrimaryKey('id'));
        $execute($tableDdl, $sql, $adapter);

    }

}

// check if columns already exist in the products table
$tableProjects = new TableGateway($tableNames[1], $adapter);
$sqlString = 'SHOW COLUMNS FROM ' . $tableProjects->getTable();
$result = $tableProjects->getAdapter()->query($sqlString)->execute();

$newColumns = getStructuresToBeCreated($columnNames, $result);

if (!empty($newColumns)) {

    $tableDdl = new AlterTable($tableNames[1], false);

    foreach ($newColumns as $column) {

        echo PHP_EOL . "<br />Column $column will be created!<br />" . PHP_EOL;

        switch($column) {
            case "{$columnNames[0]}":
                $tableDdl->addColumn(new Integer($columnNames[0]));
                break;
            case "{$columnNames[1]}":
                $tableDdl->addColumn(new Varchar($columnNames[1], 255));
                break;
            case "{$columnNames[2]}":
                $tableDdl->addColumn(new Integer($columnNames[2]));
                break;
        }

    }

    if (count($newColumns) === 3) {

        // table tmptype must exist before creating the constraint
        $tableDdl->addConstraint(new ForeignKey('fktmptype_id',
            'tmptype_id',
            'tmptype',
            'id'));

    }

    $execute($tableDdl, $sql, $adapter);

} else {

    $tableDdl = new DropTable($tableNames[0]);
    $execute($tableDdl, $sql, $adapter);

    $tableDdl = new AlterTable($tableNames[1], false);

    foreach ($columnNames as $column) {
        $tableDdl->dropColumn($column);
    }

    $execute($tableDdl, $sql, $adapter);

    echo PHP_EOL . '<br />The database was reset. <a href="">Please reload the page!</a><br />';

}

echo PHP_EOL;
