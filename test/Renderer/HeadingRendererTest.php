<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\HeadingRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the heading renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HeadingRendererTest extends TestCase
{
    /**
     * Test for the heading rendering
     */
    public function testHeadingRendering(): void
    {
        $renderer = new HeadingRenderer();
        static::assertSame('<h1>Test</h1>', $renderer->render(new Heading(new Text('Test'), 1)));
        static::assertSame('<h2>Test</h2>', $renderer->render(new Heading(new Text('Test'), 2)));
        static::assertSame('<h3>Test</h3>', $renderer->render(new Heading(new Text('Test'), 3)));
        static::assertSame('<h4>Test</h4>', $renderer->render(new Heading(new Text('Test'), 4)));
        static::assertSame('<h5>Test</h5>', $renderer->render(new Heading(new Text('Test'), 5)));
        static::assertSame('<h6>Test</h6>', $renderer->render(new Heading(new Text('Test'), 6)));
    }
}
