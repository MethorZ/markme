<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest;

use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Element\Tracker;
use MethorZ\MarkMe\Exception\RendererException;
use MethorZ\MarkMe\Markdown;
use MethorZ\MarkMe\Parser;
use MethorZ\MarkMeTest\Assets\Renderer\FakeDependency;
use MethorZ\MarkMeTest\Assets\Renderer\FakeRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the markdown
 *
 * @package MethorZ\MarkMeTest
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class MarkdownTest extends TestCase
{
    private Markdown $markdown;

    /**
     * Tests setting a renderer for an element
     */
    public function testSetRenderer(): void
    {
        $this->markdown->setRenderer(Paragraph::class, FakeRenderer::class, [FakeDependency::class]);

        self::assertEquals(
            'Fake renderer triggered for ' . Paragraph::class . ' with dependency ' . FakeDependency::class,
            $this->markdown->html('Some text')
        );
    }

    /**
     * Test exception when setting a renderer for an element that does not exist
     */
    public function testSetRendererForNonExistingElement(): void
    {
        $this->expectException(RendererException::class);
        $this->expectExceptionMessage('Element class does not exist: ' . NonExistingElement::class);

        $this->markdown->setRenderer(NonExistingElement::class, FakeRenderer::class);
    }

    /**
     * Test exception when setting a renderer that does not exist
     */
    public function testSetNonExistingRenderer(): void
    {
        $this->expectException(RendererException::class);
        $this->expectExceptionMessage('Renderer class does not exist: ' . NonExistingRenderer::class);

        $this->markdown->setRenderer(Paragraph::class, NonExistingRenderer::class);
    }

    /**
     * Test exception when trying to set a renderer with a non existing dependency
     */
    public function testSetRendererWithNonExistingDependency(): void
    {
        $this->expectException(RendererException::class);
        $this->expectExceptionMessage('Renderer dependency does not exist: ' . NonExistingDependency::class);

        $this->markdown->setRenderer(Paragraph::class, FakeRenderer::class, [NonExistingDependency::class]);
    }

    /**
     * Test html rendering of a markdown string
     */
    public function testHtml(): void
    {
        $markdown = file_get_contents(__DIR__ . '/Assets/markdown.md');
        $expectedHtml = rtrim(file_get_contents(__DIR__ . '/Assets/markdown.html'), PHP_EOL);

        self::assertEquals($expectedHtml, $this->markdown->html($markdown));
    }

    /**
     * Set up the test case
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->markdown = new Markdown(
            new Parser(
                new Tracker()
            )
        );
    }
}
