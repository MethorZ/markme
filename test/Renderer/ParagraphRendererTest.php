<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\ParagraphRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the paragraph renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ParagraphRendererTest extends TestCase
{
    /**
     * Test for the paragraph rendering
     */
    public function testParagraphRendering(): void
    {
        $text = new Text('This is a paragraph.');
        $paragraph = new Paragraph();
        $paragraph->addLine($text);

        $renderer = new ParagraphRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer()));
        $html = $renderer->render($paragraph);

        self::assertEquals('<p>This is a paragraph.</p>', $html);
    }
}
