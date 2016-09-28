<?php

use function DI\factory;
use function DI\object;
use Interop\Container\ContainerInterface;
use PhpParser\Parser;
use PhpSchool\BackToBasics\Exercise\FirstStringsFirst;
use PhpSchool\BackToBasics\Exercise\Numbers;
use PhpSchool\BackToBasics\Exercise\Variables;

return [
    // Exercises
    Variables::class         => factory(function (ContainerInterface $c) {
        return new Variables($c->get(Parser::class));
    }),
    FirstStringsFirst::class => factory(function (ContainerInterface $c) {
        return new FirstStringsFirst($c->get(Parser::class));
    }),
    Numbers::class => factory(function (ContainerInterface $c) {
        return new Numbers($c->get(Parser::class));
    }),
];
