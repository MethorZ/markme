<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\Comment;
use MethorZ\MarkMe\Renderer\CommentRenderer;
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
     * Test for the comment rendering
     */
    public function testCommentRendering(): void
    {
        $comment = 'This is a comment.';
        $expectedOutput = '<!-- ' . $comment . ' -->';

        $comment = new Comment($comment);

        $commentRenderer = new CommentRenderer();
        $output = $commentRenderer->render($comment);

        self::assertEquals($expectedOutput, $output);
    }
}
