<?php

namespace PhpSchool\BackToBasics\Exercise;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat;
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
 * Class Strings
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class Strings extends AbstractExercise implements ExerciseInterface, CliExercise, SelfCheck
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
        return 'First Strings First';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Taking your first look at PHP strings and concatination';
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

        $concat = null;
        foreach ($statements as $statement) {
            // On assignment
            if ($statement instanceof Expr && $statement->expr instanceof Concat) {
                $concat = true;
                break;
            }

            // On echo
            if ($statement instanceof Stmt) {
                foreach ($statement->exprs as $expr) {
                    if ($expr instanceof Concat) {
                        $concat = true;
                        break 2;
                    }
                }
            }
        }

        if (null === $concat) {
            return Failure::fromNameAndReason($this->getName(), 'No string concat performed');
        }

        return new Success($this->getName());
    }
}
