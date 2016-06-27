<?php

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Predicate\NotLike;
use Zend\Debug\Debug;

include 'init_autoloader.php';

$adapter = new Adapter(include 'database_params.php');
$sql = new Sql($adapter);

$run = function (Select $select, Sql $sql, Adapter $adapter) {
    Debug::dump($sql->getSqlStringForSqlObject($select));
    $result = $adapter->query($sql->getSqlStringForSqlObject($select),
        Adapter::QUERY_MODE_EXECUTE);
    return $result;
};

/**************************/
// SELECT `products`.* FROM `products`
echo '<br />Example 1' . PHP_EOL;
$select = new Select();
$select->from('products');
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
// SELECT `products`.`sku` AS `sku`, `products`.`pid` AS `pid` FROM `products`
echo '<br />Example 2' . PHP_EOL;
$select = new Select();
$select->from('products')->columns(['sku', 'pid']);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
// SELECT `products`.`sku` AS `product_number` FROM `products`
echo '<br />Example 3' . PHP_EOL;
$select = new Select();
$select->from('products')->columns(['product_number' => 'sku']);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
// SELECT `products`.`sku` AS `product_number`, `products`.`pid` AS `pid` FROM `products`
echo '<br />Example 4' . PHP_EOL;
$select = new Select();
$select->from('products')->columns(['product_number' => 'sku', 'pid']);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
// SELECT COUNT(DISTINCT(sku)) AS `total_products` FROM `products`
echo '<br />Example 5' . PHP_EOL;
$select = new Select();
$select->from('products')->columns(['total_products' => new Expression('COUNT(DISTINCT(sku))')]);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
// SELECT (COUNT(DISTINCT(`sku`)) + '10') AS `total_products` FROM `products`
echo '<br />Example 6' . PHP_EOL;
$select = new Select();
$select->from('products')->columns(
    [
        new Expression(
            '(COUNT(DISTINCT(?)) + ?) AS ?',
            ['sku', 10, 'total_products'],
            [
                Expression::TYPE_IDENTIFIER,
                Expression::TYPE_VALUE,
                Expression::TYPE_IDENTIFIER
            ]
        )
    ]
);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
// SELECT `zend`.`products`.* FROM `zend`.`products`
echo '<br />Example 7' . PHP_EOL;
$select = new Select();
$select->from(new TableIdentifier('products', 'zend'));
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
// SELECT `p`.* FROM `products` AS `p`
echo '<br />Example 8' . PHP_EOL;
$select = new Select();
$select->from(['p' => new TableIdentifier('products')]);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
/*
 * SELECT `products`.*, `purchases`.*
 * FROM `products`
 * INNER JOIN `purchases` ON `products`.`sku` = `purchases`.`sku`
 */
echo '<br />Example 9' . PHP_EOL;
$select = new Select();
$select->from('products')->join('purchases', 'products.sku = purchases.sku');
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
/*
 * SELECT `products`.*
 * FROM `products`
 * LEFT JOIN `purchases` ON `products`.`sku` = `purchases`.`sku`
 */
echo '<br />Example 10' . PHP_EOL;
$select = new Select();
$select->from('products')->join('purchases', 'products.sku = purchases.sku', [], Select::JOIN_LEFT);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
// SELECT `products`.* FROM `products` WHERE sku = 16751
echo '<br />Example 11' . PHP_EOL;
$select = new Select();
$select->from('products')->where('sku = 16751');
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
/*
 * SELECT `products`.*
 * FROM `products`
 * WHERE `cost` >= '85'
 * AND `unit` NOT LIKE ''
 * ORDER BY `unit` ASC
 */
echo '<br />Example 12' . PHP_EOL;
$where = new Where();
$where->greaterThanOrEqualTo('cost', 85)
        ->and
        ->notLike('unit', '');
$select = new Select();
$select->from('products')
        ->columns(['*'])
        ->where($where)
        ->order(['unit' => 'asc']);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
/*
 * SELECT `products`.*
 * FROM `products`
 * WHERE (`cost` >= '85'
 * AND `unit` NOT LIKE '')
 * ORDER BY `unit` ASC
 */
echo '<br />Example 13' . PHP_EOL;
$predicate = new Predicate();
$predicate->greaterThanOrEqualTo('cost', 85);
$predicate->addPredicate(new NotLike('unit', ''));
$select = new Select();
$select->from('products')
        ->columns(['*'])
        ->where($predicate)
        ->order(['unit' => 'asc']);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
/*
 * SELECT `products`.*
 * FROM `products`
 * RIGHT JOIN `purchases` ON `products`.`sku` = `purchases`.`sku`
 * GROUP BY `purchases`.`sku`
 */
echo '<br />Example 14' . PHP_EOL;
$select = new Select();
$select->from('products')
        ->join('purchases', 'products.sku = purchases.sku', [], Select::JOIN_RIGHT)
        ->group('purchases.sku');
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
/*
 * SELECT `products`.`sku` AS `sku`, SUM(price) AS `total_sales`
 * FROM `products`
 * LEFT JOIN `purchases` ON `products`.`sku` = `purchases`.`sku`
 * GROUP BY `products`.`sku`
 * HAVING (`total_sales` >= '80')
 * ORDER BY `total_sales` ASC
 */
echo '<br />Example 15' . PHP_EOL;
$where = new Where();
$select = new Select();
$select->from('products')
        ->columns(['sku'])
        ->join(
            'purchases',
            'products.sku = purchases.sku',
            ['total_sales' => new Expression('SUM(price)')],
            Select::JOIN_LEFT
        )
        ->group('products.sku')
        ->having($where->greaterThanOrEqualTo('total_sales', 80))
        ->order(['total_sales' => 'asc']);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
/*
 * SELECT `products`.`sku` AS `sku`,
 *        `products`.`pid` AS `pid`,
 *        `products`.`unit` AS `unit`,
 *        `products`.`cost` AS `cost`,
 *        `products`.`qty_oh` AS `qty_oh`,
 *        DAY(`purchases`.`date`) AS `order_day`
 * FROM `products`
 * LEFT JOIN `purchases` ON `products`.`sku` = `purchases`.`sku`
 * GROUP BY `order_day`
 * ORDER BY `order_day` DESC
 * LIMIT 5
 * OFFSET 5
 */
echo '<br />Example 16' . PHP_EOL;
$select = new Select();
$select->from('products')
        ->columns(
            [
                'sku',
                'pid',
                'unit',
                'cost',
                'qty_oh',
                'order_day' => new Expression(
                    'DAY(?)',
                    ['purchases.date'],
                    [Expression::TYPE_IDENTIFIER]
                )
            ]
        )
        ->join('purchases', 'products.sku = purchases.sku', [], Select::JOIN_LEFT)
        ->group(['order_day'])
        ->order(['order_day' => 'desc'])
        ->limit(5)
        ->offset(5);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());

/**************************/
/*
 * SELECT `products`.*
 * FROM `products`
 * WHERE `sku` IN ((SELECT MAX(`sku`) AS Expression1 FROM `purchases`))
 */
echo '<br />Example 17' . PHP_EOL;
$sqlExpression = new Expression('MAX(`sku`)');
$subSelect = new Select();
$subSelect->from('purchases')
        ->columns([$sqlExpression]);
$where = new Where();
$where->in('sku', ['sku' => $subSelect]);
$select = new Select();
$select->from('products');
$select->where($where);
$result = $run($select, $sql, $adapter);
Debug::dump($result->current());
