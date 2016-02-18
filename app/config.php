<?php

use function DI\factory;
use function DI\object;
use PhpParser\Parser;
use PhpSchool\BackToBasics\Exercise\Variables;

return [
    // Exercises
    Variables::class => factory(function (ContainerInterface $c) {
        return new Variables(
            $c->get(Parser::class)
        );
    })
];
