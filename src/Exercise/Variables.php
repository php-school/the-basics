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
use PhpSchool\PhpWorkshop\Input\Input;
use PhpSchool\PhpWorkshop\Result\Failure;
use PhpSchool\PhpWorkshop\Result\ResultInterface;
use PhpSchool\PhpWorkshop\Result\Success;
use PhpSchool\PhpWorkshop\Solution\SingleFileSolution;

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
     * Overwrite to provdide simpler naming
     *
     * @return string
     */
    public function getSolution()
    {
        return SingleFileSolution::fromFile(
            realpath(sprintf('%s/../../exercises/variables/solution/solution.php', __DIR__))
        );
    }

    /**
     * Overwrite to provdide simpler naming
     *
     * @return string
     */
    public function getProblem()
    {
        return sprintf('%s/../../exercises/%s/problem/problem.md', __DIR__, 'variables');
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
        $program = $input->getArgument('program');

        try {
            $ast = $this->parser->parse(file_get_contents($program));
        } catch (Error $e) {
            return Failure::fromCheckAndCodeParseFailure($this, $e, $program);
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
