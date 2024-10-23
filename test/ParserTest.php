<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest;

use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Parser;
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
    /**
     * Test the blockquote parsing
     */
    public function testBlockQuoteParser(): void
    {
        $parser = new Parser();

        /** @var array<\MethorZ\MarkMe\Element\BlockQuote> $elements*/
        $elements = $parser->parse('> This is a blockquote');

        foreach ($elements as $blockQuote) {
            foreach ($blockQuote->getLines() as $line) {
                self::assertEquals('This is a blockquote', $line->getText());
            }
        }
    }

    /**
     * Test the comment parsing
     */
    public function testCommentParser(): void
    {
        $parser = new Parser();

        /** @var array<\MethorZ\MarkMe\Element\Comment> $elements*/
        $elements = $parser->parse('<!-- This is a comment -->');

        foreach ($elements as $comment) {
            self::assertEquals('This is a comment', $comment->getComment());
        }
    }

    /**
     * Test the heading parsing
     */
    public function testHeadingParser(): void
    {
        $parser = new Parser();

        for ($level = 1; $level <= 6; $level++) {
            $markdown = str_repeat('#', $level) . ' Heading ' . $level;

            /** @var array<\MethorZ\MarkMe\Element\Heading> $elements*/
            $elements = $parser->parse($markdown);

            foreach ($elements as $heading) {
                self::assertEquals('Heading ' . $level, $heading->getText());
                self::assertEquals($level, $heading->getLevel());
            }
        }
    }

    /**
     * Test the horizontal rule parsing
     */
    public function testHorizontalRuleParser(): void
    {
        $parser = new Parser();

        /** @var array<\MethorZ\MarkMe\Element\HorizontalRule> $elements*/
        $elements = $parser->parse('---');

        foreach ($elements as $horizontalRule) {
            self::assertInstanceOf(HorizontalRule::class, $horizontalRule);
        }
    }

    /**
     * Test the list block parsing
     */
    public function testListBlockParser(): void
    {
        $parser = new Parser();

        /** @var array<\MethorZ\MarkMe\Element\ListBlock> $elements*/
        $elements = $parser->parse("- Item 1\n- Item 2");

        foreach ($elements as $listBlock) {
            // Test list block
            $items = $listBlock->getItems();
            self::assertCount(2, $items);
            self::assertFalse($listBlock->isOrdered());
            self::assertEquals(0, $listBlock->getIndentation());

            // Test list items
            self::assertEquals('Item 1', $items[0]->getContent());
            self::assertEquals('Item 2', $items[1]->getContent());
        }
    }

    /**
     * Test the paragraph parsing
     */
    public function testParagraphParser(): void
    {
        $parser = new Parser();

        /** @var array<\MethorZ\MarkMe\Element\Paragraph> $elements*/
        $elements = $parser->parse('This is a paragraph.');

        foreach ($elements as $paragraph) {
            self::assertEquals('This is a paragraph.', $paragraph->getLines()[0]->getText());
        }
    }
}
