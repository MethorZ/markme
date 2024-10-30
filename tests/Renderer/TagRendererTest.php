<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Renderer\NewLineRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMeTest\Assets\TagTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the tag renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class TagRendererTest extends TestCase
{
    private TagRenderer $renderer;
    private NewLineRenderer $newLineRenderer;

    /**
     * Test rendering of a @tag
     */
    public function testRenderTag(): void
    {
        $expectation = rtrim(file_get_contents(__DIR__ . '/../Assets/tag.html'), PHP_EOL);
        $elements = TagTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            if ($element instanceof NewLine) {
                $html .= $this->newLineRenderer->render($element);

                continue;
            }

            if ($element instanceof Tag) {
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

        $this->renderer = new TagRenderer();
        $this->newLineRenderer = new NewLineRenderer();
    }
}
