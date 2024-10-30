<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Renderer\HeadingRenderer;
use MethorZ\MarkMe\Renderer\NewLineRenderer;
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
    private NewLineRenderer $newLineRenderer;

    /**
     * Test heading rendering
     */
    public function testHeadingParser(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../assets/heading.html');
        $elements = HeadingTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            if ($element instanceof NewLine) {
                $html .= $this->newLineRenderer->render($element);

                continue;
            }

            if ($element instanceof Heading) {
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

        $this->renderer = new HeadingRenderer();
        $this->newLineRenderer = new NewLineRenderer();
    }
}
