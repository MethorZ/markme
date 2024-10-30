<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\NewLineRenderer;
use MethorZ\MarkMe\Renderer\ParagraphRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use MethorZ\MarkMeTest\Assets\ParagraphTestProvider;
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
    private ParagraphRenderer $renderer;
    private NewLineRenderer $newLineRenderer;

    /**
     * Test the rendering of a paragraph
     */
    public function testParagraphRender(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../Assets/paragraph.html');
        $elements = ParagraphTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            if ($element instanceof NewLine) {
                $html .= $this->newLineRenderer->render($element);

                continue;
            }

            if ($element instanceof Paragraph) {
                $html .= $this->renderer->render($element);
            }
        }

        self::assertSame($expectation, $html);
    }

    /**
     * Set up the test case
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->renderer = new ParagraphRenderer(
            new TextRenderer(
                new ImageRenderer(),
                new TagRenderer()
            )
        );

        $this->newLineRenderer = new NewLineRenderer();
    }
}
