<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\BlockQuoteRenderer;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
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
    /**
     * Test for the block quote rendering
     */
    public function testBlockQuoteRendering(): void
    {
        $input = 'This is a blockquote.';
        $expectedOutput = '<blockquote><p>This is a blockquote.</p></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($input));

        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $renderer = new BlockQuoteRenderer($textRenderer);
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }
}
