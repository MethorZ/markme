<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\BlockQuoteRenderer;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Blockquote element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuoteTest extends TestCase
{
    /**
     * Tests the blockquote rendering
     */
    public function testSingleLineBlockQuoteRender(): void
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

    /**
     * Test multiline blockquote rendering
     */
    public function testMultiLineBlockQuoteRender(): void
    {
        $inputLines = [
            'This is a blockquote.',
            'With multiple lines.',
        ];
        $expectedOutput = '<blockquote><p>This is a blockquote.</p><p>With multiple lines.</p></blockquote>';

        $blockQuote = new BlockQuote();

        foreach ($inputLines as $line) {
            $blockQuote->addLine(new Text($line));
        }

        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $renderer = new BlockQuoteRenderer($textRenderer);
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test nested blockquote rendering
     */
    public function testNestedBlockQuoteRender(): void
    {
        $deeplyNestedBlockQuote = new BlockQuote();
        $deeplyNestedBlockQuote->addLine(new Text('This is a deeply nested third level blockquote.'));

        $nestedBlockQuote = new BlockQuote();
        $nestedBlockQuote->addLine(new Text('This is a nested second level blockquote.'));
        $nestedBlockQuote->addLine($deeplyNestedBlockQuote);

        $primaryBlockQuoteInput = 'This is a first level blockquote.';

        $expectedOutput = '<blockquote><p>This is a first level blockquote.</p><blockquote><p>This is a nested second level blockquote.</p><blockquote><p>This is a deeply nested third level blockquote.</p></blockquote></blockquote></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($primaryBlockQuoteInput));
        $blockQuote->addLine($nestedBlockQuote);

        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $renderer = new BlockQuoteRenderer($textRenderer);
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test blockquote rendering with inline link
     */
    public function testBlockQuoteRenderWithLink(): void
    {
        $input = 'This is a blockquote with a [link](https://example.com)';
        $expectedOutput = '<blockquote><p>This is a blockquote with a <a href="https://example.com">link</a></p></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($input));

        $renderer = new BlockQuoteRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer()));
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test blockquote rendering with inline image
     */
    public function testBlockQuoteRenderWithImage(): void
    {
        $input = 'This is a blockquote with an ![image](https://example.com/image.jpg)';
        $expectedOutput = '<blockquote><p>This is a blockquote with an <img src="https://example.com/image.jpg" alt="image" /></p></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($input));

        $renderer = new BlockQuoteRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer()));
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test blockquote rendering with image inside a link
     */
    public function testBlockQuoteRenderWithImageInsideLink(): void
    {
        $input = 'This is a blockquote with an [![image](https://example.com/image.jpg)](https://example.com)';
        $expectedOutput = '<blockquote><p>This is a blockquote with an <a href="https://example.com"><img src="https://example.com/image.jpg" alt="image" /></a></p></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($input));

        $renderer = new BlockQuoteRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer()));
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test blockquote rendering when containing bold elements
     */
    public function testBlockQuoteRenderWithBold(): void
    {
        $input = 'This is a blockquote with **bold text**.';
        $expectedOutput = '<blockquote><p>This is a blockquote with <strong>bold text</strong>.</p></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($input));

        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $renderer = new BlockQuoteRenderer($textRenderer);
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test blockquote rendering when containing italic elements
     */
    public function testBlockQuoteRenderWithItalic(): void
    {
        $input = 'This is a blockquote with *italic text*.';
        $expectedOutput = '<blockquote><p>This is a blockquote with <em>italic text</em>.</p></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($input));

        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $renderer = new BlockQuoteRenderer($textRenderer);
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test blockquote rendering when bold and italic elements
     */
    public function testBlockQuoteRenderWithBoldAndItalic(): void
    {
        $input = 'This is a blockquote with *italic text* and **bold text**.';
        $expectedOutput = '<blockquote><p>This is a blockquote with <em>italic text</em> and <strong>bold text</strong>.</p></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($input));

        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $renderer = new BlockQuoteRenderer($textRenderer);
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test blockquote rendering when bold and italic elements
     */
    public function testBlockQuoteRenderWithMergedBoldAndItalic(): void
    {
        $input = 'This is a blockquote with ***italic bold text***.';
        $expectedOutput = '<blockquote><p>This is a blockquote with <strong><em>italic bold text</em></strong>.</p></blockquote>';

        $blockQuote = new BlockQuote();
        $blockQuote->addLine(new Text($input));

        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $renderer = new BlockQuoteRenderer($textRenderer);
        $output = $renderer->render($blockQuote);

        self::assertEquals($expectedOutput, $output);
    }
}
