<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Comment;
use MethorZ\MarkMe\Renderer\CommentRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the comment renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class CommentRendererTest extends TestCase
{
    /**
     * Test for the comment rendering
     */
    public function testCommentRendering(): void
    {
        $input = 'This is a comment.';
        $expectedOutput = '<!-- This is a comment. -->';

        $comment = new Comment($input);

        $commentRenderer = new CommentRenderer();
        $output = $commentRenderer->render($comment);

        self::assertEquals($expectedOutput, $output);
    }
}
