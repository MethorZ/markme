<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\Paragraph;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Paragraph element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ParagraphTest extends TestCase
{
    /**
     * Tests tryCreate with a single line
     */
    public function testSingleLine(): void
    {
        $markdown = 'Hello World';
        $result = Paragraph::tryCreate($markdown);

        self::assertInstanceOf(Paragraph::class, $result);
        self::assertSame($markdown, $result->getLines()[0]->getText());
    }

    /**
     * Tests the paragraph with multiple lines
     */
    public function testMultipleLines(): void
    {
        $markdown = "Hello\nWorld";
        $result = Paragraph::tryCreate($markdown);

        self::assertInstanceOf(Paragraph::class, $result);
        self::assertSame('Hello', $result->getLines()[0]->getText());
        self::assertSame('World', $result->getLines()[1]->getText());
    }

    /**
     * Tests the paragraph with html breaks
     */
    public function testHtmlBreaks(): void
    {
        $markdown = "Hello<br />World";
        $result = Paragraph::tryCreate($markdown);

        self::assertInstanceOf(Paragraph::class, $result);
        self::assertSame('Hello<br />World', $result->getLines()[0]->getText());
    }

    /**
     * Tests the paragraph with no lines
     */
    public function testNoLines(): void
    {
        $markdown = '';
        $result = Paragraph::tryCreate($markdown);

        self::assertFalse($result);
    }
}
