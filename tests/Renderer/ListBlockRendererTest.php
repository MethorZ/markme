<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\ListBlockRenderer;
use MethorZ\MarkMe\Renderer\ListItemRenderer;
use MethorZ\MarkMe\Renderer\NewLineRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use MethorZ\MarkMeTest\Assets\ListBlockTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the list block renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListBlockRendererTest extends TestCase
{
    private ListBlockRenderer $renderer;
    private NewLineRenderer $newLineRenderer;

    /**
     * Test list block rendering
     */
    public function testListBlockRenderer(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../assets/list-block.html');
        $elements = ListBlockTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            if ($element instanceof NewLine) {
                $html .= $this->newLineRenderer->render($element);

                continue;
            }

            if ($element instanceof ListBlock) {
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

        $this->renderer = new ListBlockRenderer(
            new ListItemRenderer(
                new TextRenderer(
                    new ImageRenderer(),
                    new TagRenderer()
                )
            )
        );

        $this->newLineRenderer = new NewLineRenderer();
    }
}
