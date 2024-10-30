<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Inline\Text;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the text renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class TextRendererTest extends TestCase
{
    private TextRenderer $renderer;

    /**
     * Test for bold text rendering
     */
    public function testBoldRendering(): void
    {
        $text = new Text('This is **bold** text.');
        $html = $this->renderer->render($text);
        self::assertEquals('This is <strong>bold</strong> text.', $html);
    }

    /**
     * Test for italic text rendering
     */
    public function testItalicRendering(): void
    {
        $text = new Text('This is *italic* text.');
        $html = $this->renderer->render($text);
        self::assertEquals('This is <em>italic</em> text.', $html);
    }

    /**
     * Test for bold italic text rendering
     */
    public function testBoldItalicRendering(): void
    {
        $text = new Text('This is ***bold italic*** text.');
        $html = $this->renderer->render($text);
        self::assertEquals('This is <strong><em>bold italic</em></strong> text.', $html);
    }

    /**
     * Test for strikethrough text rendering
     */
    public function testStrikethroughRendering(): void
    {
        $text = new Text('This is ~~strikethrough~~ text.');
        $html = $this->renderer->render($text);
        self::assertEquals('This is <del>strikethrough</del> text.', $html);
    }

    /**
     * Test for code text rendering
     */
    public function testCodeRendering(): void
    {
        $text = new Text('This is `code` text.');
        $html = $this->renderer->render($text);
        self::assertEquals('This is <code>code</code> text.', $html);
    }

    /**
     * Test for subscript text rendering
     */
    public function testSubscriptRendering(): void
    {
        $text = new Text('This is ~subscript~ text.');
        $html = $this->renderer->render($text);
        self::assertEquals('This is <sub>subscript</sub> text.', $html);
    }

    /**
     * Test for superscript text rendering
     */
    public function testSuperscriptRendering(): void
    {
        $text = new Text('This is ^superscript^ text.');
        $html = $this->renderer->render($text);
        self::assertEquals('This is <sup>superscript</sup> text.', $html);
    }

    /**
     * Test for underlined text rendering
     */
    public function testUnderlinedRendering(): void
    {
        $text = new Text('This is __underlined__ text.');
        $html = $this->renderer->render($text);
        self::assertEquals('This is <u>underlined</u> text.', $html);
    }

    /**
     * Test for image rendering
     */
    public function testImageRendering(): void
    {
        $text = new Text('This is an image ![alt text](image.jpg).');
        $html = $this->renderer->render($text);
        // Assuming the mock image renderer returns a specific string for testing
        self::assertEquals('This is an image <img src="image.jpg" alt="alt text" />.', $html);
    }

    /**
     * Test for link rendering
     */
    public function testLinkRendering(): void
    {
        $text = new Text('This is a [link](http://example.com).');
        $html = $this->renderer->render($text);
        self::assertEquals('This is a <a href="http://example.com">link</a>.', $html);
    }

    /**
     * Test for custom tag rendering
     */
    public function testTagRendering(): void
    {
        $text = new Text('This is a #customTag');
        $html = $this->renderer->render($text);

        // Assuming the mock tag renderer returns a specific string for testing
        self::assertEquals('This is a <tag>#customTag</tag>', $html);
    }

    /**
     * Set up the tests
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->renderer = new TextRenderer(new ImageRenderer(), new TagRenderer());
    }
}
