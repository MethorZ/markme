<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\Comment;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Comment element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class CommentTest extends TestCase
{
    /**
     * Test tryCreate method with valid markdown
     */
    public function testTryCreateWithValidMarkdown(): void
    {
        $markdown = '<!-- This is a comment -->';

        $comment = Comment::tryCreate($markdown);

        self::assertInstanceOf(Comment::class, $comment);
        self::assertSame('This is a comment', $comment->getComment());
    }

    /**
     * Test tryCreate method with invalid markdown
     */
    public function testTryCreateWithInvalidMarkdown(): void
    {
        $markdown = 'This is not a comment';

        $comment = Comment::tryCreate($markdown);

        self::assertFalse($comment);
    }

    /**
     * Test tryCreate method with invalid markdown
     */
    public function testTryCreateWithInvalidMarkdown2(): void
    {
        $markdown = '<!-- This is not a comment';

        $comment = Comment::tryCreate($markdown);

        self::assertFalse($comment);
    }

    /**
     * Test tryCreate method with invalid markdown
     */
    public function testTryCreateWithInvalidMarkdown3(): void
    {
        $markdown = 'This is not a comment -->';

        $comment = Comment::tryCreate($markdown);

        self::assertFalse($comment);
    }

    /**
     * Test tryCreate method with multi line comment
     */
    public function testTryCreateWithMultiLineComment(): void
    {
        $markdown = '<!-- This is a comment' . PHP_EOL . 'with multiple lines -->';

        $comment = Comment::tryCreate($markdown);

        self::assertInstanceOf(Comment::class, $comment);
        self::assertSame("This is a comment\nwith multiple lines", $comment->getComment());
    }
}
