<?php
include 'init_autoloader.php';

$validator = new Zend\I18n\Validator\IsFloat();

$validator->setLocale('en_US');

// bool(true)
echo 'EN: 1234.5  ';
var_dump($validator->isValid(1234.5)); 

// bool(false)
echo 'EN: 10a01   ';
var_dump($validator->isValid('10a01')); 

// bool(true)
echo 'EN: 1,234.5 ';
var_dump($validator->isValid('1,234.5')); 

// bool(true)
echo 'EN: 1.234,5 ';
var_dump($validator->isValid('1.234,5')); 

$validator->setLocale('de_DE');

// bool(true)
echo 'DE: 1234.5  ';
var_dump($validator->isValid(1234.5)); 

// bool(false)
echo 'DE: 10a01   ';
var_dump($validator->isValid('10a01')); 

// bool(true)
echo 'DE: 1,234.5 ';
var_dump($validator->isValid('1,234.5')); 

// bool(true)
echo 'DE: 1.234,5 ';
var_dump($validator->isValid('1.234,5')); 

