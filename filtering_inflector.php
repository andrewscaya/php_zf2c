<?php
// why do you not include ":" for "suffix"?
// working hypothesis: ':' ==> filter

include 'init_autoloader.php';

// Transform `MixedCase` and `camelCaseText` to another format
$inflector= new Zend\Filter\Inflector('pages/:page.:suffix');
$inflector->setRules(
    array(
        ':page' => array('Word\CamelCaseToDash', 'StringToLower'),
        'suffix' => 'html',
));
$string = 'camelCasedWords';
$filtered = $inflector->filter(array('page'=> $string));
// pages/camel-cased-words.html
echo $filtered . PHP_EOL;

$string = 'This_Is_Not_Camel_Cased';
$filtered = $inflector->filter(array('page' => $string));
// pages/this_is_not_camel_cased.html
echo $filtered . PHP_EOL;
