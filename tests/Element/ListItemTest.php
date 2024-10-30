<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\ListItem;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the ListItem element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListItemTest extends TestCase
{
    /**
     * Tests the tryCreate method
     */
    public function testTryCreate(): void
    {
        $markdown = '- Test List Item';
        $element = ListItem::tryCreate($markdown);

        self::assertInstanceOf(ListItem::class, $element);
        self::assertEquals('Test List Item', $element->getContent()->getText());
    }
}
