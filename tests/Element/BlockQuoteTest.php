<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\BlockQuote;
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
