<?php

namespace PhpSchool\BackToBasicsTest\Exercise;

use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpSchool\BackToBasics\Exercise\Variables;
use PhpSchool\PhpWorkshop\Exercise\ExerciseType;
use PhpSchool\PhpWorkshop\Result\Failure;
use PhpSchool\PhpWorkshop\Result\Success;
use PhpSchool\PhpWorkshop\Solution\SolutionInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class VariablesTest
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class VariablesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    }

    public function testVariablesExercise()
    {
        $exercise = new Variables($this->parser);

        $this->assertEquals('Variables', $exercise->getName());
        $this->assertEquals('Taking your first look at PHP variables', $exercise->getDescription());
        $this->assertEquals(ExerciseType::CLI(), $exercise->getType());
        $this->assertEquals([], $exercise->getArgs());
        $this->assertInstanceOf(SolutionInterface::class, $exercise->getSolution());
        $this->assertFileExists(realpath($exercise->getProblem()));
        $this->assertNull($exercise->tearDown());
    }

    public function testCheckFailsWIthNoVariablesDeclared()
    {
        $exercise = new Variables($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/variables/without-variables.php');

        $this->assertInstanceOf(Failure::class, $result);
        $this->assertEquals('No variable declared', $result->getReason());
        $this->assertEquals('Variables', $result->getCheckName());
    }

    public function testCheckPassesWithVariablesDeclared()
    {
        $exercise = new Variables($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/variables/correct-solution.php');

        $this->assertInstanceOf(Success::class, $result);
        $this->assertEquals('Variables', $result->getCheckName());
    }
}
