<?php

namespace PhpSchool\BackToBasics\Exercise;

use Error;
use PhpParser\Node\Expr\Assign;
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
 * Class Variables
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class Variables extends AbstractExercise implements ExerciseInterface, CliExercise, SelfCheck
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
        return 'Variables are a Devs Best Friend!';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Taking your first look at PHP variables';
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

        $nodeVisitor = new RequiredNodeVisitor([Assign::class]);
        $traverser   = new NodeTraverser();

        $traverser->addVisitor($nodeVisitor);
        $traverser->traverse($ast);

        if (!$nodeVisitor->hasUsedRequiredNodes()) {
            return Failure::fromNameAndReason($this->getName(), 'No variable declared');
        }

        return new Success($this->getName());
    }
}
