<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Inline\Text;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Blockquote element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuoteTest extends TestCase
{
    /**
     * Test tryCreate of the BlockQuote element
     */
    public function testTryCreate(): void
    {
        $input = '> This is a blockquote.';
        $result = BlockQuote::tryCreate($input);

        self::assertInstanceOf(BlockQuote::class, $result);
    }

    /**
     * Test tryCreate of the BlockQuote element with a nested blockquote
     */
    public function testTryCreateWithNestedBlockQuote(): void
    {
        $input = '> Top level blockquote.'
            . PHP_EOL . '> Also top level blockquote.'
            . PHP_EOL . '>> First nested blockquote level.'
            . PHP_EOL . '>> Also first nested blockquote level.'
            . PHP_EOL . '>>> Third nested blockquote level.'
            . PHP_EOL . '>> Again second level blockquote.'
            . PHP_EOL . '>>> Alternate third level blockquote.'
            . PHP_EOL . '> Sudden first level blockquote.';

        $blockQuote = BlockQuote::tryCreate($input);

        self::assertInstanceOf(BlockQuote::class, $blockQuote);

        $lines = $blockQuote->getLines();
        self::assertCount(4, $lines);

        // First level assertions
        self::assertInstanceOf(Text::class, $lines[0]);
        self::assertEquals('Top level blockquote.', $lines[0]->getText());

        self::assertInstanceOf(Text::class, $lines[1]);
        self::assertEquals('Also top level blockquote.', $lines[1]->getText());

        self::assertInstanceOf(Text::class, $lines[3]);
        self::assertEquals('Sudden first level blockquote.', $lines[3]->getText());

        self::assertInstanceOf(BlockQuote::class, $lines[2]);
        $nestedLevel1 = $lines[2]->getLines();
        self::assertCount(5, $nestedLevel1);

        // Second level assertions
        self::assertInstanceOf(Text::class, $nestedLevel1[0]);
        self::assertEquals('First nested blockquote level.', $nestedLevel1[0]->getText());

        self::assertInstanceOf(Text::class, $nestedLevel1[1]);
        self::assertEquals('Also first nested blockquote level.', $nestedLevel1[1]->getText());

        self::assertInstanceOf(Text::class, $nestedLevel1[3]);
        self::assertEquals('Again second level blockquote.', $nestedLevel1[3]->getText());

        self::assertInstanceOf(BlockQuote::class, $nestedLevel1[2]);
        $nestedLevel2a = $nestedLevel1[2]->getLines();
        self::assertCount(1, $nestedLevel2a);

        self::assertInstanceOf(BlockQuote::class, $nestedLevel1[4]);
        $nestedLevel2b = $nestedLevel1[4]->getLines();
        self::assertCount(1, $nestedLevel2b);

        // Third level assertions
        self::assertInstanceOf(Text::class, $nestedLevel2a[0]);
        self::assertEquals('Third nested blockquote level.', $nestedLevel2a[0]->getText());

        // Third level additional assertions
        self::assertInstanceOf(Text::class, $nestedLevel2b[0]);
        self::assertEquals('Alternate third level blockquote.', $nestedLevel2b[0]->getText());
    }

    /**
     * Tests the tryCreate method for invalid list block
     */
    public function testTryCreateOnInvalidListBlock(): void
    {
        $invalidTestCases = [
            '>Unsupported Blockquote',
            '>>Unsupported Blockquote',
            '>>>Unsupported Blockquote',
            '<Unsupported Blockquote',
            'Unsupported Blockquote',
        ];

        foreach ($invalidTestCases as $input) {
            $listBlock = BlockQuote::tryCreate($input);

            self::assertFalse($listBlock);
        }
    }
}
