<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Renderer\CommentRenderer;
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

    /**
     * Test comment rendering
     */
    public function testCommentParser(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../assets/comment.html');
        $elements = CommentTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            $html .= $this->renderer->render($element) . "\n";
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
    }
}
