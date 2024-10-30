<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Renderer\HorizontalRuleRenderer;
use MethorZ\MarkMe\Renderer\NewLineRenderer;
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
    private NewLineRenderer $newLineRenderer;

    /**
     * Test horizontal rule rendering
     */
    public function testHorizontalRuleParser(): void
    {
        $expectation = file_get_contents(__DIR__ . '/../assets/horizontal-rule.html');
        $elements = HorizontalRuleTestProvider::getElements();

        $html = '';

        foreach ($elements as $element) {
            if ($element instanceof NewLine) {
                $html .= $this->newLineRenderer->render($element);
            }

            if ($element instanceof HorizontalRule) {
                $html .= $this->renderer->render($element);
            }
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
        $this->newLineRenderer = new NewLineRenderer();
    }
}
