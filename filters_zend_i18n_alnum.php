<?php
// What is the output?

include 'init_autoloader.php';

$filter = new Zend\I18n\Filter\Alnum(TRUE);
echo $filter->filter('This is (my) content: 123 -- Ând this too!');
echo PHP_EOL;

$filter = new Zend\I18n\Filter\Alnum();
echo $filter->filter('This is (my) content: 123 -- Ând this too!');
echo PHP_EOL;
