<?php

namespace PhpSchool\BackToBasicsTest\Exercise;

use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpSchool\BackToBasics\Exercise\FirstStringsFirst;
use PhpSchool\PhpWorkshop\Exercise\ExerciseType;
use PhpSchool\PhpWorkshop\Result\Failure;
use PhpSchool\PhpWorkshop\Result\Success;
use PhpSchool\PhpWorkshop\Solution\SolutionInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class FirstStringsFirstTest
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class FirstStringsFirstTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    }

    public function testStringExercise()
    {
        $exercise = new FirstStringsFirst($this->parser);

        $this->assertEquals('First Strings First', $exercise->getName());
        $this->assertEquals('Taking your first look at PHP strings and concatination', $exercise->getDescription());
        $this->assertEquals(ExerciseType::CLI(), $exercise->getType());
        $this->assertEquals([], $exercise->getArgs());
        $this->assertInstanceOf(SolutionInterface::class, $exercise->getSolution());
        $this->assertFileExists(realpath($exercise->getProblem()));
        $this->assertNull($exercise->tearDown());
    }

    public function testCheckFailsWithNoStringConcat()
    {
        $exercise = new FirstStringsFirst($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/first-strings-first/without-concat.php');

        $this->assertInstanceOf(Failure::class, $result);
        $this->assertEquals('No string concat performed', $result->getReason());
        $this->assertEquals('First Strings First', $result->getCheckName());
    }

    public function testCheckPassesWithConcatPerformedOnEcho()
    {
        $exercise = new FirstStringsFirst($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/first-strings-first/echo-correct-solution.php');

        $this->assertInstanceOf(Success::class, $result);
        $this->assertEquals('First Strings First', $result->getCheckName());
    }

    public function testCheckPassesWithConcatPerformedOnVariableAssignment()
    {
        $exercise = new FirstStringsFirst($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/first-strings-first/assign-correct-solution.php');

        $this->assertInstanceOf(Success::class, $result);
        $this->assertEquals('First Strings First', $result->getCheckName());
    }
}
