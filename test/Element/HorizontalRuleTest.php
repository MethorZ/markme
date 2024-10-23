<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Renderer\HorizontalRuleRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Horizontal Rule element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HorizontalRuleTest extends TestCase
{
    /**
     * Test for the horizontal rule rendering
     */
    public function testHorizontalRuleRendering(): void
    {
        $expectedOutput = '<hr />';

        $horizontalRule = new HorizontalRule();
        $horizontalRuleRenderer = new HorizontalRuleRenderer();
        $output = $horizontalRuleRenderer->render($horizontalRule);

        self::assertEquals($expectedOutput, $output);
    }
}
