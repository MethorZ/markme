<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the text element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class TextTest extends TestCase
{
    /**
     * Test for the text rendering
     */
    public function testTextRender(): void
    {
        $input = 'This is a text.';
        $expectedOutput = 'This is a text.';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with bold text
     */
    public function testTextRenderBold(): void
    {
        $input = '**This is a bold text.**';
        $expectedOutput = '<strong>This is a bold text.</strong>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with italic text
     */
    public function testTextRenderItalic(): void
    {
        $input = '*This is an italic text.*';
        $expectedOutput = '<em>This is an italic text.</em>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with strikethrough text
     */
    public function testTextRenderStrikethrough(): void
    {
        $input = '~~This is a strikethrough text.~~';
        $expectedOutput = '<del>This is a strikethrough text.</del>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with code text
     */
    public function testTextRenderCode(): void
    {
        $input = '`This is a code text.`';
        $expectedOutput = '<code>This is a code text.</code>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with subscript text
     */
    public function testTextRenderSubscript(): void
    {
        $input = '~This is a subscript text.~';
        $expectedOutput = '<sub>This is a subscript text.</sub>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with superscript text
     */
    public function testTextRenderSuperscript(): void
    {
        $input = '^This is a superscript text.^';
        $expectedOutput = '<sup>This is a superscript text.</sup>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with underlined text
     */
    public function testTextRenderUnderlined(): void
    {
        $input = '__This is an underlined text.__';
        $expectedOutput = '<u>This is an underlined text.</u>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with image
     */
    public function testTextRenderImage(): void
    {
        $input = '![This is an image](https://example.com/image.jpg)';
        $expectedOutput = '<img src="https://example.com/image.jpg" alt="This is an image" />';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with link
     */
    public function testTextRenderLink(): void
    {
        $input = '[This is a link](https://example.com)';
        $expectedOutput = '<a href="https://example.com">This is a link</a>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with tags
     */
    public function testTextRenderTags(): void
    {
        $input = '#tag';
        $expectedOutput = '<tag>#tag</tag>';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for text rendering with tags and attributes
     */
    public function testTextRenderTagsWithAttributes(): void
    {
        $input = 'This is a #tag{#tagid .tagclass --single-attribute attribute-key=attribute-value} with attributes.';
        $expectedOutput = 'This is a <tag id="tagid" class="tagclass" --single-attribute attribute-key=attribute-value>#tag</tag> with attributes.';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with html tag
     */
    public function testTextRenderTagsWithHtmlBreakTag(): void
    {
        $input = 'This is a #tag<br /> with html break.';
        $expectedOutput = 'This is a <tag>#tag</tag><br /> with html break.';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with html tag
     */
    public function testTextRenderTagsWithHtmlBreakTagAfterTag(): void
    {
        $input = 'This is a #tag <br />with html break.';
        $expectedOutput = 'This is a <tag>#tag</tag> <br />with html break.';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the text rendering with multiple html tags in a single line
     */
    public function testTextRenderTagsWithMultipleHtmlTags(): void
    {
        $input = 'This is a #tag <br />with html break, a normal #tag and a tag with concatenated break #tag<br /> here.';
        $expectedOutput = 'This is a <tag>#tag</tag> <br />with html break, a normal <tag>#tag</tag> and a tag with concatenated break <tag>#tag</tag><br /> here.';

        $text = new Text($input);
        $textRenderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
        $output = $textRenderer->render($text);

        self::assertEquals($expectedOutput, $output);
    }
}
