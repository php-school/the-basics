<?php

ini_set('display_errors', 1);
date_default_timezone_set('Europe/London');

switch (true) {
    case (file_exists(__DIR__ . '/../vendor/autoload.php')):
        // Installed standalone
        require __DIR__ . '/../vendor/autoload.php';
        break;
    case (file_exists(__DIR__ . '/../../../autoload.php')):
        // Installed as a Composer dependency
        require __DIR__ . '/../../../autoload.php';
        break;
    case (file_exists('vendor/autoload.php')):
        // As a Composer dependency, relative to CWD
        require 'vendor/autoload.php';
        break;
    default:
        throw new RuntimeException('Unable to locate Composer autoloader; please run "composer install".');
}

use PhpSchool\BackToBasics\Exercise\FirstStringsFirst;
use PhpSchool\BackToBasics\Exercise\Numbers;
use PhpSchool\BackToBasics\Exercise\Variables;
use PhpSchool\PhpWorkshop\Application;

$app = new Application('The Basics', __DIR__ . '/config.php');

$app->addExercise(Variables::class);
$app->addExercise(FirstStringsFirst::class);
$app->addExercise(Numbers::class);

$art = <<<ART
    _ __ _
   / |..| \
   \/ || \/
    |_''_|

  PHP SCHOOL
BACK TO BASICS
ART;

$app->setLogo($art);
$app->setFgColour('magenta');
$app->setBgColour('black');

return $app;
