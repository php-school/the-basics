<?php

namespace PhpSchool\BackToBasics\Exercise;

use PhpParser\Node\Expr\Assign;
use PhpParser\Parser;
use PhpSchool\PhpWorkshop\Exercise\AbstractExercise;
use PhpSchool\PhpWorkshop\Exercise\CliExercise;
use PhpSchool\PhpWorkshop\Exercise\ExerciseInterface;
use PhpSchool\PhpWorkshop\Exercise\ExerciseType;
use PhpSchool\PhpWorkshop\ExerciseCheck\SelfCheck;
use PhpSchool\PhpWorkshop\Input\Input;
use PhpSchool\PhpWorkshop\Result\Failure;
use PhpSchool\PhpWorkshop\Result\ResultInterface;
use PhpSchool\PhpWorkshop\Result\Success;
use PhpSchool\PhpWorkshop\Solution\SingleFileSolution;

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
     * Overwrite to provdide simpler naming
     *
     * @return string
     */
    public function getSolution()
    {
        return SingleFileSolution::fromFile(
            realpath(sprintf('%s/../../exercises/numbers/solution/solution.php', __DIR__))
        );
    }

    /**
     * Overwrite to provdide simpler naming
     *
     * @return string
     */
    public function getProblem()
    {
        return sprintf('%s/../../exercises/%s/problem/problem.md', __DIR__, 'numbers');
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
     * @param Input $input
     * @return ResultInterface
     */
    public function check(Input $input)
    {
        $statements = $this->parser->parse(file_get_contents($input->getArgument('program')));

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
