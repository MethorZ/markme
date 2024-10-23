<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest;

use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Exception\RendererException;
use MethorZ\MarkMe\Markdown;
use MethorZ\MarkMe\Parser;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the markdown
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class MarkdownTest extends TestCase
{
    /**
     * Test adding an element
     */
    public function testAddElement(): void
    {
        $parser = $this->createMock(Parser::class);
        $markdown = new Markdown($parser);
        $element = $this->createMock(Heading::class);

        $markdown->addElement($element);
        $elements = $markdown->getElements();

        self::assertCount(1, $elements);
        self::assertSame($element, $elements[0]);
    }

    /**
     * Test getting the elements
     */
    public function testGetElements(): void
    {
        $parser = $this->createMock(Parser::class);
        $markdown = new Markdown($parser);
        $element = $this->createMock(Heading::class);

        $markdown->addElement($element);
        $elements = $markdown->getElements();

        self::assertCount(1, $elements);
        self::assertSame($element, $elements[0]);
    }

    /**
     * Test parsing the markdown
     */
    public function testParse(): void
    {
        $parser = $this->createMock(Parser::class);
        $parser->method('parse')->willReturn([$this->createMock(Heading::class)]);
        $markdown = new Markdown($parser);

        $markdown->parse('# Heading 1');
        $elements = $markdown->getElements();

        self::assertCount(1, $elements);
        self::assertInstanceOf(Heading::class, $elements[0]);
    }

    /**
     * Test setting a renderer throws an exception for an invalid class
     */
    public function testSetRendererThrowsExceptionForInvalidClass(): void
    {
        $this->expectException(RendererException::class);

        $parser = $this->createMock(Parser::class);
        $markdown = new Markdown($parser);

        $markdown->setRenderer(Heading::class, 'InvalidRendererClass');
    }
}
