<?php

namespace PhpSchool\BackToBasicsTest\Exercise;

use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpSchool\BackToBasics\Exercise\Strings;
use PhpSchool\PhpWorkshop\Exercise\ExerciseType;
use PhpSchool\PhpWorkshop\Result\Failure;
use PhpSchool\PhpWorkshop\Result\Success;
use PhpSchool\PhpWorkshop\Solution\SolutionInterface;
use PHPUnit_Framework_TestCase;

/**
 * Class StringsTest
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class StringsTest extends PHPUnit_Framework_TestCase
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
        $exercise = new Strings($this->parser);

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
        $exercise = new Strings($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/strings/without-concat.php');

        $this->assertInstanceOf(Failure::class, $result);
        $this->assertEquals('No string concat performed', $result->getReason());
        $this->assertEquals('First Strings First', $result->getCheckName());
    }

    public function testCheckPassesWithConcatPerformed()
    {
        $exercise = new Strings($this->parser);
        $result   = $exercise->check(__DIR__ . '/../res/strings/correct-solution.php');

        $this->assertInstanceOf(Success::class, $result);
        $this->assertEquals('First Strings First', $result->getCheckName());
    }
}
