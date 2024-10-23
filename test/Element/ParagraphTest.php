<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\ParagraphRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Paragraph element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ParagraphTest extends TestCase
{
    /**
     * Test for the paragraph rendering using single line
     */
    public function testParagraphRendering(): void
    {
        $content = 'This is a paragraph.';
        $expectedOutput = '<p>' . $content . '</p>';

        $paragraph = new Paragraph();
        $paragraph->addLine(new Text($content));

        $paragraphRenderer = new ParagraphRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer()));
        $output = $paragraphRenderer->render($paragraph);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the paragraph rendering using multiple lines
     */
    public function testParagraphRenderingMultipleLines(): void
    {
        $content = 'This is a paragraph line.';
        $content2 = 'This is another paragraph line.';
        $expectedOutput = '<p>' . $content . ' ' . $content2 . '</p>';

        $paragraph = new Paragraph();
        $paragraph->addLine(new Text($content));
        $paragraph->addLine(new Text($content2));

        $paragraphRenderer = new ParagraphRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer()));
        $output = $paragraphRenderer->render($paragraph);

        self::assertEquals($expectedOutput, $output);
    }
}
