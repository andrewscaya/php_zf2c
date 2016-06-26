<?php
include 'init_autoloader.php';

/*
return [
    ''              => [
        'plural_forms'  => 'nplurals=2; plural=(n==0 || n==1 ? 0 : 1)',
    ],
    'Welcome'       => 'Bienvenue',
    'to'            => 'a',
    'my'            => 'mon',
    'my_plural'     => 'mes',
    'mystr'         => ['mon', 'mes'],
    'my2'           => 'ma',
    'my2_plural'    => 'mes',
    'my2str'         => ['ma', 'mes'],
    'house'         => 'maison',
    'house_plural'  => 'maisons',
    'housestr'      => ['maison', 'maisons'],
];
*/

use Zend\I18n\Translator\Translator;
use Zend\EventManager\EventManager;

$translator = new Translator();
$evm        = new EventManager();

$type       = 'phparray';
$pattern    = 'locale/%s/messages.php';
$textDomain = 'mystrings';

$translator->setLocale('fr');
$translator->setEventManager($evm);
$translator->enableEventManager();
$translator->addTranslationFilePattern($type, __DIR__, $pattern, $textDomain);

// attach listeners to translation events
$listenerMissing   = function ($e) { echo "Missing Translation\n"; };
$listenerNotLoaded = function ($e) { echo "Messages Not Loaded\n"; };
$evm->attach(Translator::EVENT_MISSING_TRANSLATION, $listenerMissing);
$evm->attach(Translator::EVENT_NO_MESSAGES_LOADED,  $listenerNotLoaded);

echo $translator->translate('Welcome', 'mystrings') . "!\n\n"; // Bienvenue!

printf(
    "'house' in french: " . $translator->translate('house', 'mystrings') . "\n\n" // maison
);

// translate a message - singular in french
$num = 0;
printf(
    "%d " . $translator->translatePlural('housestr', 'house_plural', $num, 'mystrings') . "\n\n", // 0 maison
    $num
);

// translate a message - singular
$num = 1;
printf(
    "%d " . $translator->translatePlural('housestr', 'house_plural', $num, 'mystrings') . "\n\n", // 1 maison
    $num
);

// translate a message - plural
$num = 3;
printf(
    "%d " . $translator->translatePlural('housestr', 'house_plural', $num, 'mystrings') . "\n\n", // 3 maisons
    $num
);