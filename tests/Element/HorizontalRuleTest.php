<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\HorizontalRule;
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
     * Tests the creation of a horizontal rule element
     */
    public function testCreate(): void
    {
        $element = HorizontalRule::tryCreate('---');
        self::assertInstanceOf(HorizontalRule::class, $element);
    }
}
