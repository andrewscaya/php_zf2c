<?php

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\AbstractSql;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Stdlib\ArrayUtils;
use Zend\Debug\Debug;

$adapter = new Zend\Db\Adapter\Adapter(include 'database_params.php');
$sql = new Zend\Db\Sql\Sql($adapter);

$execute = function (AbstractSql $tableDdl, Sql $sql, Adapter $adapter) {
    Debug::dump($sql->getSqlStringForSqlObject($tableDdl));
    $adapter->query($sql->getSqlStringForSqlObject($tableDdl),
        Adapter::QUERY_MODE_EXECUTE);
};

function getStructuresToBeCreated(Array $needle, ResultInterface $haystack)
{
    $haystack = ArrayUtils::iteratorToArray($haystack);

    $numberOfElements = count($needle);

    $existingElements = [];

    array_walk_recursive(
        $haystack,
        function ($item, $key) use ($needle, $numberOfElements, &$existingElements) {
            for ($i = 0; $i < $numberOfElements; $i++) {
                switch($item) {
                    case "{$needle[$i]}":
                        $existingElements[] = $needle[$i];
                        break;
                }
            }
        }
    );

    if (count($existingElements) < $numberOfElements) {

        $newElements = array_diff($needle, $existingElements);
        return $newElements;

    } else {

        return [];

    }
}
