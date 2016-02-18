<?php

use function DI\factory;
use function DI\object;
use Interop\Container\ContainerInterface;
use PhpParser\Parser;
use PhpSchool\BackToBasics\Exercise\Strings;
use PhpSchool\BackToBasics\Exercise\Variables;

return [
    // Exercises
    Variables::class => factory(function (ContainerInterface $c) {
        return new Variables($c->get(Parser::class));
    }),
    Strings::class => factory(function (ContainerInterface $c) {
        return new Strings($c->get(Parser::class));
    })
];
