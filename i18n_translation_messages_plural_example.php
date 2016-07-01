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

return [
    ''              => [
        'plural_forms'  => 'nplurals=2; plural=(n != 1);',
    ],
    'Welcome'       => 'Willkommen',
    'house'         => 'haus',
    'house_plural'  => 'häuser',
    'housestr'      => ['haus', 'häuser'],
];
*/

use Zend\I18n\Translator\Translator;
use Zend\EventManager\EventManager;

$translator = new Translator();
$evm        = new EventManager();

$type       = 'phparray';
$pattern    = 'locale/%s/messages.php';
$textDomain = 'mystrings';

if (isset($_GET['lang']) && $_GET['lang'] == 'de') {
	$translator->setLocale('de');
	$language = 'German';
} else {
	$translator->setLocale('fr');
	$language = 'French';
	echo '<br /><a href="?p=i18n_translation_messages_plural_example.php&lang=de">German translations</a><br /><br /><br />';
}

$translator->setEventManager($evm);
$translator->enableEventManager();
$translator->addTranslationFilePattern($type, __DIR__, $pattern, $textDomain);

// attach listeners to translation events
$listenerMissing   = function ($e) { echo "Missing Translation\n"; };
$listenerNotLoaded = function ($e) { echo "Messages Not Loaded\n"; };
$evm->attach(Translator::EVENT_MISSING_TRANSLATION, $listenerMissing);
$evm->attach(Translator::EVENT_NO_MESSAGES_LOADED,  $listenerNotLoaded);

echo $translator->translate('Welcome', 'mystrings') . "!<br /><br />"; // Bienvenue!, Willkommen!

printf(
    "'house' in $language: " . $translator->translate('house', 'mystrings') . "<br /><br />" // maison
);

// translate a message - singular in French, plural in German
$num = 0;
printf(
    "%d " . $translator->translatePlural('housestr', 'house_plural', $num, 'mystrings') . "<br /><br />", // 0 maison, 0 häuser
    $num
);

// translate a message - singular
$num = 1;
printf(
    "%d " . $translator->translatePlural('housestr', 'house_plural', $num, 'mystrings') . "<br /><br />", // 1 maison, 1 haus
    $num
);

// translate a message - plural
$num = 3;
printf(
    "%d " . $translator->translatePlural('housestr', 'house_plural', $num, 'mystrings') . "<br /><br />", // 3 maisons, 3 häuser
    $num
);
