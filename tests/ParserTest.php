<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest;

use MethorZ\MarkMe\Element\Tracker;
use MethorZ\MarkMe\Exception\ParseException;
use MethorZ\MarkMe\Parser;
use MethorZ\MarkMeTest\Assets\BlockQuoteTestProvider;
use MethorZ\MarkMeTest\Assets\CommentTestProvider;
use MethorZ\MarkMeTest\Assets\FrontMatterTestProvider;
use MethorZ\MarkMeTest\Assets\HeadingTestProvider;
use MethorZ\MarkMeTest\Assets\HorizontalRuleTestProvider;
use MethorZ\MarkMeTest\Assets\ListBlockTestProvider;
use MethorZ\MarkMeTest\Assets\ParagraphTestProvider;
use MethorZ\MarkMeTest\Assets\TagTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the markdown parser
 *
 * @package MethorZ\MarkMeTest
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ParserTest extends TestCase
{
    private Parser $parser;

    /**
     * Test the blockquote parsing
     */
    public function testBlockQuoteParser(): void
    {
        $expectations = BlockQuoteTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/Assets/blockquote.md');

        $elements = $this->parser->parse($markdown);

        foreach ($expectations as $index => $expectation) {
            self::assertEquals($expectation, $elements[$index]);
        }
    }

    /**
     * Test the comment parsing
     */
    public function testCommentParser(): void
    {
        $expectations = CommentTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/Assets/comment.md');

        $elements = $this->parser->parse($markdown);

        foreach ($expectations as $index => $expectation) {
            self::assertEquals($expectation, $elements[$index]);
        }
    }

    /**
     * Test the heading parsing
     */
    public function testHeadingParser(): void
    {
        $expectations = HeadingTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/Assets/heading.md');

        $elements = $this->parser->parse($markdown);

        foreach ($expectations as $index => $expectation) {
            self::assertEquals($expectation, $elements[$index]);
        }
    }

    /**
     * Test horizontal rule parsing
     */
    public function testHorizontalRuleParser(): void
    {
        $expectations = HorizontalRuleTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/Assets/horizontal-rule.md');

        $elements = $this->parser->parse($markdown);

        foreach ($expectations as $index => $expectation) {
            self::assertEquals($expectation, $elements[$index]);
        }
    }

    /**
     * Test the list block parsing
     */
    public function testListBlockParser(): void
    {
        $expectations = ListBlockTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/Assets/list-block.md');

        $elements = $this->parser->parse($markdown);

        foreach ($expectations as $index => $expectation) {
            self::assertEquals($expectation, $elements[$index]);
        }
    }

    /**
     * Test the tag parsing
     */
    public function testTagParser(): void
    {
        $expectations = TagTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/Assets/tag.md');

        $elements = $this->parser->parse($markdown);

        foreach ($expectations as $index => $expectation) {
            self::assertEquals($expectation, $elements[$index]);
        }
    }

    /**
     * Test paragraph parsing
     */
    public function testParagraphParser(): void
    {
        $expectations = ParagraphTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/Assets/paragraph.md');

        $elements = $this->parser->parse($markdown);

        foreach ($expectations as $index => $expectation) {
            self::assertEquals($expectation, $elements[$index]);
        }
    }

    /**
     * Test front matter parsing
     */
    public function testFrontMatterParser(): void
    {
        $expectations = FrontMatterTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/Assets/front-matter.md');

        $elements = $this->parser->parse($markdown);

        foreach ($expectations as $index => $expectation) {
            self::assertEquals($expectation, $elements[$index]);
        }
    }

    /**
     * Test front matter parsing after a different element was already created
     */
    public function testFrontMatterParserFails(): void
    {
        $markdown = "# This is an element that renders the next front matter invalid\n---\ntitle: \"This is an example title\"\n---\n";

        self::expectException(ParseException::class);
        self::expectExceptionMessage('Unable to parse the front matter. There is a different element being tracked already.');

        $this->parser->parse($markdown);
    }

    /**
     * Set up the test
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new Parser(new Tracker());
    }
}
