<?php

namespace PhpSchool\BackToBasics\Exercise;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt;
use PhpParser\Parser;
use PhpSchool\PhpWorkshop\Exercise\AbstractExercise;
use PhpSchool\PhpWorkshop\Exercise\CliExercise;
use PhpSchool\PhpWorkshop\Exercise\ExerciseInterface;
use PhpSchool\PhpWorkshop\Exercise\ExerciseType;
use PhpSchool\PhpWorkshop\ExerciseCheck\SelfCheck;
use PhpSchool\PhpWorkshop\Result\Failure;
use PhpSchool\PhpWorkshop\Result\ResultInterface;
use PhpSchool\PhpWorkshop\Result\Success;

/**
 * Class Numbers
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class Numbers extends AbstractExercise implements ExerciseInterface, CliExercise, SelfCheck
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'Numbers... Numbers... Numbers...';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Taking your first look at PHP numbers';
    }

    /**
     * @return string[]
     */
    public function getArgs()
    {
        return [];
    }

    /**
     * @return ExerciseType
     */
    public function getType()
    {
        return ExerciseType::CLI();
    }

    /**
     * Ensure a variable was declared
     *
     * @param string $fileName
     * @return ResultInterface
     */
    public function check($fileName)
    {
        $statements = $this->parser->parse(file_get_contents($fileName));

        $variable = null;
        foreach ($statements as $statement) {
            if ($statement instanceof Assign && $statement->expr->value === 123) {
                $variable = true;
                break;
            }
        }

        if (null === $variable) {
            return Failure::fromNameAndReason($this->getName(), 'No variable declared with value 123');
        }

        return new Success($this->getName());
    }
}
