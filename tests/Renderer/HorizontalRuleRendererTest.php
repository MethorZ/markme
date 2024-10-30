<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Renderer\HorizontalRuleRenderer;
use MethorZ\MarkMeTest\Assets\HorizontalRuleTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the horizontal rule renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HorizontalRuleRendererTest extends TestCase
{
    private HorizontalRuleRenderer $renderer;

    /**
     * Test horizontal rule rendering
     */
    public function testHorizontalRuleParser(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../assets/horizontal-rule.html');
        $elements = HorizontalRuleTestProvider::getElements();

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

        $this->renderer = new HorizontalRuleRenderer();
    }
}
