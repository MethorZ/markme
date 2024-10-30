<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Element\NewLine;

/**
 * Tests cases / expectations / elements provider for horizontal rules
 *
 * @package MethorZ\MarkMeTest\Assets
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HorizontalRuleTestProvider
{
    /**
     * Create horizontal rule for testing
     *
     * @return array<\MethorZ\MarkMe\Element\HorizontalRule>
     */
    public static function getElements(): array // phpcs:ignore
    {
        $horizontalRule1 = new HorizontalRule();
        $horizontalRule2 = new HorizontalRule();
        $horizontalRule3 = new HorizontalRule();
        $horizontalRule4 = new HorizontalRule();
        $horizontalRule5 = new HorizontalRule();
        $horizontalRule6 = new HorizontalRule();

        return [
            $horizontalRule1,
            new NewLine(),
            $horizontalRule2,
            new NewLine(),
            $horizontalRule3,
            new NewLine(),
            $horizontalRule4,
            new NewLine(),
            $horizontalRule5,
            new NewLine(),
            $horizontalRule6,
        ];
    }
}
