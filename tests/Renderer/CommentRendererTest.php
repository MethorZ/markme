<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Comment;
use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Renderer\CommentRenderer;
use MethorZ\MarkMe\Renderer\NewLineRenderer;
use MethorZ\MarkMeTest\Assets\CommentTestProvider;
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
    private CommentRenderer $renderer;
    private NewLineRenderer $newLineRenderer;

    /**
     * Test comment rendering
     */
    public function testCommentParser(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../assets/comment.html');
        $elements = CommentTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            if ($element instanceof NewLine) {
                $html .= $this->newLineRenderer->render($element);

                continue;
            }

            if ($element instanceof Comment) {
                $html .= $this->renderer->render($element);
            }
        }

        self::assertSame($expectation, $html);
    }

    /**
     * Set up the test
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->renderer = new CommentRenderer();
        $this->newLineRenderer = new NewLineRenderer();
    }
}
