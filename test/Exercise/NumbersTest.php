<?php

namespace PhpSchool\BackToBasicsTest\Exercise;

use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpSchool\BackToBasics\Exercise\Numbers;
use PhpSchool\PhpWorkshop\Exercise\ExerciseType;
use PhpSchool\PhpWorkshop\Result\Failure;
use PhpSchool\PhpWorkshop\Result\Success;
use PhpSchool\PhpWorkshop\Solution\SolutionInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class NumbersTest
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class NumbersTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    }

    public function testNumbersExercise()
    {
        $exercise = new Numbers($this->parser);

        $this->assertEquals('Numbers', $exercise->getName());
        $this->assertEquals('Taking your first look at PHP numbers', $exercise->getDescription());
        $this->assertEquals(ExerciseType::CLI(), $exercise->getType());
        $this->assertEquals([], $exercise->getArgs());
        $this->assertInstanceOf(SolutionInterface::class, $exercise->getSolution());
        $this->assertFileExists(realpath($exercise->getProblem()));
        $this->assertNull($exercise->tearDown());
    }

    public function testCheckFailsWIthNoNumbersDeclared()
    {
        $exercise = new Numbers($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/numbers/without-variable.php');

        $this->assertInstanceOf(Failure::class, $result);
        $this->assertEquals('No variable declared with value 123', $result->getReason());
        $this->assertEquals('Numbers', $result->getCheckName());
    }

    public function testCheckFailsWhenWrongValueIsAssigned()
    {
        $exercise = new Numbers($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/numbers/incorrect-value.php');

        $this->assertInstanceOf(Failure::class, $result);
        $this->assertEquals('No variable declared with value 123', $result->getReason());
        $this->assertEquals('Numbers', $result->getCheckName());
    }

    public function testCheckPassesWithNumbersDeclared()
    {
        $exercise = new Numbers($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/Numbers/correct-solution.php');

        $this->assertInstanceOf(Success::class, $result);
        $this->assertEquals('Numbers', $result->getCheckName());
    }
}
