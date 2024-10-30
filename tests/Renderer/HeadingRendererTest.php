<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Renderer\HeadingRenderer;
use MethorZ\MarkMeTest\Assets\HeadingTestProvider;
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
    private HeadingRenderer $renderer;

    /**
     * Test heading rendering
     */
    public function testHeadingParser(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../assets/heading.html');
        $elements = HeadingTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            $html .= $this->renderer->render($element) . "\n";
        }

        self::assertSame($expectation, $html);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->renderer = new HeadingRenderer();
    }
}
