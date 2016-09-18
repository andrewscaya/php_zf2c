<?php
// what is the output of this code?
include 'init_autoloader.php';

$original = ' Foo Bar 3 ';
$chain = new Zend\Filter\FilterChain();
$chain->attachByName('StringToLower', NULL, 500);
$chain->attachByName('StringToUpper');
$chain->attachByName('Alnum');
echo $chain->filter($original);
