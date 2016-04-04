<?php

namespace PhpSchool\BackToBasics\Exercise;

use Error;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Stmt;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use PhpSchool\BackToBasics\NodeVisitor\RequiredNodeVisitor;
use PhpSchool\PhpWorkshop\Exercise\AbstractExercise;
use PhpSchool\PhpWorkshop\Exercise\CliExercise;
use PhpSchool\PhpWorkshop\Exercise\ExerciseInterface;
use PhpSchool\PhpWorkshop\Exercise\ExerciseType;
use PhpSchool\PhpWorkshop\ExerciseCheck\SelfCheck;
use PhpSchool\PhpWorkshop\Result\Failure;
use PhpSchool\PhpWorkshop\Result\ResultInterface;
use PhpSchool\PhpWorkshop\Result\Success;

/**
 * Class FirstStringsFirst
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class FirstStringsFirst extends AbstractExercise implements ExerciseInterface, CliExercise, SelfCheck
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
        try {
            $ast = $this->parser->parse(file_get_contents($fileName));
        } catch (Error $e) {
            return Failure::fromCheckAndCodeParseFailure($this, $e, $fileName);
        }

        $nodeVisitor = new RequiredNodeVisitor([Concat::class]);
        $traverser   = new NodeTraverser();

        $traverser->addVisitor($nodeVisitor);
        $traverser->traverse($ast);

        if (!$nodeVisitor->hasUsedRequiredNodes()) {
            return Failure::fromNameAndReason($this->getName(), 'No string concat performed');
        }

        return new Success($this->getName());
    }
}
