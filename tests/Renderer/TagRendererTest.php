<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMeTest\Assets\TagTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the tag renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class TagRendererTest extends TestCase
{
    private TagRenderer $renderer;

    /**
     * Test rendering of a @tag
     */
    public function testRenderTag(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../Assets/tag.html');
        $elements = TagTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            $html .= $this->renderer->render($element) . "\n";
        }

        self::assertSame($expectation, $html);
    }

    /**
     * Set up the test case
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->renderer = new TagRenderer();
    }
}
