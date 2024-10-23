<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Renderer\HorizontalRuleRenderer;
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
    /**
     * Test for the horizontal rule rendering
     */
    public function testHorizontalRuleRendering(): void
    {
        $horizontalRule = new HorizontalRule();
        $renderer = new HorizontalRuleRenderer();
        $html = $renderer->render($horizontalRule);

        self::assertEquals('<hr />', $html);
    }
}
