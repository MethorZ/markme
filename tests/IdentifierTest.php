<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest;

use MethorZ\MarkMe\Identifier;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the markdown element identifier
 *
 * @package MethorZ\MarkMeTest
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class IdentifierTest extends TestCase
{
    /**
     * Test identification of blockquote markdown lines
     */
    public function testSuccessfulBlockQuoteIdentification(): void
    {
        $lines = [
            '> This is a blockquote',
            '>', // Empty blockquote that would generates a new paragraph
            '>> This is a nested blockquote',
            '>>> This is a deeply nested blockquote',
        ];

        foreach ($lines as $line) {
            self::assertEquals(Identifier::BLOCKQUOTE, Identifier::identify($line));
        }
    }

    /**
     * Test unsuccessful identification of blockquote markdown lines
     */
    public function testUnsuccessfulBlockQuoteIdentification(): void
    {
        $lines = [
            'This is not a blockquote',
            '>This is not a blockquote either',
            '>>This is not a blockquote as well',
            '>>>This is not a blockquot still',
        ];

        foreach ($lines as $line) {
            self::assertNotEquals(Identifier::BLOCKQUOTE, Identifier::identify($line));
        }
    }

    /**
     * Test identification of comment markdown lines
     */
    public function testSuccessfulCommentIdentification(): void
    {
        $lines = [
            '<!-- This is a comment -->',
            '<!-- This is a comment with a > character -->',
            '<!-- This is a comment with a < character -->',
            '<!-- This is a comment with a - character -->',
            '<!-- This is a comment with a ! character -->',
            '<!-- This is a comment with a - character at the end-->',
            '<!-- This is a comment with a - character at the beginning -->',
            '<!-- This is a comment with a - character in the middle -->',
            '<!-- This is a comment with a - character at the beginning and end -->',
            '<!-- This is a comment with a - character at the beginning and middle -->',
            '<!-- This is a comment with a - character at the middle and end -->',
            '<!-- This is a comment with a - character at the beginning, middle and end -->',
        ];

        foreach ($lines as $line) {
            self::assertEquals(Identifier::COMMENT, Identifier::identify($line));
        }
    }

    /**
     * Test unsuccessful identification of comment markdown lines
     */
    public function testUnsuccessfulCommentIdentification(): void
    {
        $lines = [
            'This is not a comment',
            '<!--This is not a comment either',
            '<!--This is not a comment as well',
            '<!--This is not a comment still',
            '<!--This is not a comment with a - character at the end-',
            '<!--This is not a comment with a - character at the beginning-',
            '<!--This is not a comment with a - character in the middle-',
            '<!--This is not a comment with a - character at the beginning and end-',
            '<!--This is not a comment with a - character at the beginning and middle-',
            '<!--This is not a comment with a - character at the middle and end-',
            '<!--This is not a comment with a - character at the beginning, middle and end-',
        ];

        foreach ($lines as $line) {
            self::assertNotEquals(Identifier::COMMENT, Identifier::identify($line));
        }
    }

    /**
     * Test identification of heading markdown lines
     */
    public function testSuccessfulHeadingIdentification(): void
    {
        $lines = [
            '# This is a heading 1',
            '## This is a heading 2',
            '### This is a heading 3',
            '#### This is a heading 4',
            '##### This is a heading 5',
            '###### This is a heading 6',
        ];

        foreach ($lines as $line) {
            self::assertEquals(Identifier::HEADING, Identifier::identify($line));
        }
    }

    /**
     * Test unsuccessful identification of heading markdown lines
     */
    public function testUnsuccessfulHeadingIdentification(): void
    {
        $lines = [
            'This is not a heading',
            '#This is not a heading either',
            '##This is not a heading as well',
            '###This is not a heading still',
            '####This is not a heading yet',
            '#####This is not a heading already',
            '######This is not a heading anymore',
        ];

        foreach ($lines as $line) {
            self::assertNotEquals(Identifier::HEADING, Identifier::identify($line));
        }
    }

    /**
     * Test identification of horizontal rule markdown lines
     */
    public function testSuccessfulHorizontalRuleIdentification(): void
    {
        $lines = [
            '---',
            '***',
            '___',
        ];

        foreach ($lines as $line) {
            self::assertEquals(Identifier::HORIZONTAL_RULE, Identifier::identify($line));
        }
    }

    /**
     * Test unsuccessful identification of horizontal rule markdown lines
     */
    public function testUnsuccessfulHorizontalRuleIdentification(): void
    {
        $lines = [
            'This is not a horizontal rule',
            '---This is not a horizontal rule either',
            '---This is not a horizontal rule as well',
            '---This is not a horizontal rule still',
            '---This is not a horizontal rule yet',
            '---This is not a horizontal rule already',
            '---This is not a horizontal rule anymore',
            '- - -',
            '* * *',
            '_ _ _',
            '--',
            '**',
            '__',
        ];

        foreach ($lines as $line) {
            self::assertNotEquals(Identifier::HORIZONTAL_RULE, Identifier::identify($line));
        }
    }

    /**
     * Test identification of list markdown lines
     */
    public function testSuccessfulListItemIdentification(): void
    {
        $lines = [
            '- This is a list item',
            '* This is a list item',
            '+ This is a list item',
            '1. This is a list item',
            '2. This is a list item',
        ];

        foreach ($lines as $line) {
            self::assertEquals(Identifier::LIST_BLOCK, Identifier::identify($line));
        }
    }

    /**
     * Test unsuccessful identification of list markdown lines
     */
    public function testUnsuccessfulListItemIdentification(): void
    {
        $lines = [
            'This is not a list item',
            '-This is not a list item either',
            '-- This is not a list item either',
            '*This is not a list item as well',
            '+This is not a list item still',
            '1.This is not a list item yet',
            '2.This is not a list item already',
        ];

        foreach ($lines as $line) {
            self::assertNotEquals(Identifier::LIST_BLOCK, Identifier::identify($line));
        }
    }

    /**
     * Test identification of paragraph markdown lines
     */
    public function testSuccessfulParagraphIdentification(): void
    {
        $lines = [
            'This is a paragraph with random text',
        ];

        foreach ($lines as $line) {
            self::assertEquals(Identifier::PARAGRAPH, Identifier::identify($line));
        }
    }

    /**
     * Test unsuccessful identification of paragraph markdown lines
     */
    public function testUnsuccessfulParagraphIdentification(): void
    {
        $lines = [
            '- This is not a paragraph',
            '1. This is not a paragraph either',
            '# This is not a paragraph as well',
            '---',
            '> This is not a paragraph yet',
        ];

        foreach ($lines as $line) {
            self::assertNotEquals(Identifier::PARAGRAPH, Identifier::identify($line));
        }
    }

    /**
     * Test for empty line identification
     */
    public function testEmptyLineIdentification(): void
    {
        self::assertEquals(Identifier::NEW_LINE, Identifier::identify(''));
    }
}
