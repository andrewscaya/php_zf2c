<?php
include 'init_autoloader.php';

$platform = new Zend\Db\Adapter\Platform\Mysql();

ini_set('display_errors', 0);

// `first_name`
echo __LINE__ . ':' . $platform->quoteIdentifier('first_name');
echo PHP_EOL;

// `
echo __LINE__ . ':' . $platform->getQuoteIdentifierSymbol();
echo PHP_EOL;

// `schema`.`mytable`
echo __LINE__ . ':' . $platform->quoteIdentifierChain(array('schema','mytable'));
echo PHP_EOL;

// '
echo __LINE__ . ':' . $platform->getQuoteValueSymbol();
echo PHP_EOL;

// .
echo __LINE__ . ':' . $platform->getIdentifierSeparator();
echo PHP_EOL;

// "foo" as "bar"
echo __LINE__ . ':' . $platform->quoteIdentifierInFragment('foo as bar');
echo PHP_EOL;

// additionally, with some safe words:
// ("foo"."bar" = "boo"."baz")
echo __LINE__ . ':' . $platform->quoteIdentifierInFragment('(foo.bar = boo.baz)', array('(', ')', '='));
echo PHP_EOL;

// 'myvalue'
echo __LINE__ . ':' . $platform->quoteTrustedValue('trustedValue');
echo PHP_EOL;

// 'myvalue'
echo __LINE__ . ':' . $platform->quoteValue('myvalue');
echo PHP_EOL;

// 'value', 'Foo O\\'Bar'
echo __LINE__ . ':' . $platform->quoteValueList(array('value',"Foo O'Bar"));
echo PHP_EOL;

