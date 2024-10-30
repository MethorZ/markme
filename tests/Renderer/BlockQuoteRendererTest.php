<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Renderer\BlockQuoteRenderer;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use MethorZ\MarkMeTest\Assets\BlockQuoteTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the block quote renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuoteRendererTest extends TestCase
{
    private BlockQuoteRenderer $renderer;

    /**
     * Test block quote rendering
     */
    public function testBlockQuoteParser(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../assets/blockquote.html');
        $elements = BlockQuoteTestProvider::getElements();

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

        $this->renderer = new BlockQuoteRenderer(
            new TextRenderer(
                new ImageRenderer(),
                new TagRenderer()
            )
        );
    }
}
