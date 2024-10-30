<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the ListBlock element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListBlockTest extends TestCase
{
    /**
     * Tests the tryCreate method for the list block
     */
    public function testTryCreateOnUnorderedNestedList(): void
    {
        $input = '- Top level element 1'
            . PHP_EOL . '- Top level element 2'
            . PHP_EOL . '   - First indent list element 1'
            . PHP_EOL . '   - First indent list element 2'
            . PHP_EOL . '       - Second indent list element 1'
            . PHP_EOL . '   - Again first indent list element 3'
            . PHP_EOL . '       - Alternate second level element 1'
            . PHP_EOL . '- Sudden top level element.';

        $listBlock = ListBlock::tryCreate($input);

        self::assertInstanceOf(ListBlock::class, $listBlock);
        self::assertFalse($listBlock->isOrdered());

        $items = $listBlock->getItems();
        self::assertCount(4, $items);

        // First level assertions
        self::assertInstanceOf(ListItem::class, $items[0]);
        self::assertEquals('Top level element 1', $items[0]->getContent());

        self::assertInstanceOf(ListItem::class, $items[1]);
        self::assertEquals('Top level element 2', $items[1]->getContent());

        self::assertInstanceOf(ListItem::class, $items[3]);
        self::assertEquals('Sudden top level element.', $items[3]->getContent());

        self::assertInstanceOf(ListBlock::class, $items[2]);
        self::assertFalse($items[2]->isOrdered());
        $nestedLevel1 = $items[2]->getItems();
        self::assertCount(5, $nestedLevel1);

        // Second level assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel1[0]);
        self::assertEquals('First indent list element 1', $nestedLevel1[0]->getContent());

        self::assertInstanceOf(ListItem::class, $nestedLevel1[1]);
        self::assertEquals('First indent list element 2', $nestedLevel1[1]->getContent());

        self::assertInstanceOf(ListItem::class, $nestedLevel1[3]);
        self::assertEquals('Again first indent list element 3', $nestedLevel1[3]->getContent());

        self::assertInstanceOf(ListBlock::class, $nestedLevel1[2]);
        self::assertFalse($nestedLevel1[2]->isOrdered());
        $nestedLevel2a = $nestedLevel1[2]->getItems();
        self::assertCount(1, $nestedLevel2a);

        self::assertInstanceOf(ListBlock::class, $nestedLevel1[4]);
        self::assertFalse($nestedLevel1[4]->isOrdered());
        $nestedLevel2b = $nestedLevel1[4]->getItems();
        self::assertCount(1, $nestedLevel2b);

        // Third level assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel2a[0]);
        self::assertEquals('Second indent list element 1', $nestedLevel2a[0]->getContent());

        // Third level additional assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel2b[0]);
        self::assertEquals('Alternate second level element 1', $nestedLevel2b[0]->getContent());
    }

    /**
     * Tests the tryCreate method for the list block
     */
    public function testTryCreateOnOrderedNestedList(): void
    {
        $input = '1. Top level element 1'
            . PHP_EOL . '2. Top level element 2'
            . PHP_EOL . '   1. First indent list element 1'
            . PHP_EOL . '   2. First indent list element 2'
            . PHP_EOL . '       1. Second indent list element 1'
            . PHP_EOL . '   3. Again first indent list element 3'
            . PHP_EOL . '       1. Alternate second level element 1'
            . PHP_EOL . '3. Sudden top level element.';

        $listBlock = ListBlock::tryCreate($input);

        self::assertInstanceOf(ListBlock::class, $listBlock);
        self::assertTrue($listBlock->isOrdered());

        $items = $listBlock->getItems();
        self::assertCount(4, $items);

        // First level assertions
        self::assertInstanceOf(ListItem::class, $items[0]);
        self::assertEquals('Top level element 1', $items[0]->getContent());

        self::assertInstanceOf(ListItem::class, $items[1]);
        self::assertEquals('Top level element 2', $items[1]->getContent());

        self::assertInstanceOf(ListItem::class, $items[3]);
        self::assertEquals('Sudden top level element.', $items[3]->getContent());

        self::assertInstanceOf(ListBlock::class, $items[2]);
        self::assertTrue($items[2]->isOrdered());
        $nestedLevel1 = $items[2]->getItems();
        self::assertCount(5, $nestedLevel1);

        // Second level assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel1[0]);
        self::assertEquals('First indent list element 1', $nestedLevel1[0]->getContent());

        self::assertInstanceOf(ListItem::class, $nestedLevel1[1]);
        self::assertEquals('First indent list element 2', $nestedLevel1[1]->getContent());

        self::assertInstanceOf(ListItem::class, $nestedLevel1[3]);
        self::assertEquals('Again first indent list element 3', $nestedLevel1[3]->getContent());

        self::assertInstanceOf(ListBlock::class, $nestedLevel1[2]);
        self::assertTrue($nestedLevel1[2]->isOrdered());
        $nestedLevel2a = $nestedLevel1[2]->getItems();
        self::assertCount(1, $nestedLevel2a);

        self::assertInstanceOf(ListBlock::class, $nestedLevel1[4]);
        self::assertTrue($nestedLevel1[4]->isOrdered());
        $nestedLevel2b = $nestedLevel1[4]->getItems();
        self::assertCount(1, $nestedLevel2b);

        // Third level assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel2a[0]);
        self::assertEquals('Second indent list element 1', $nestedLevel2a[0]->getContent());

        // Third level additional assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel2b[0]);
        self::assertEquals('Alternate second level element 1', $nestedLevel2b[0]->getContent());
    }

    /**
     * Tests the tryCreate method for the list block
     */
    public function testTryCreateOnMixedNestedList(): void
    {
        $input = '1. Top level element 1'
            . PHP_EOL . '2. Top level element 2'
            . PHP_EOL . '   - First indent list element 1'
            . PHP_EOL . '   - First indent list element 2'
            . PHP_EOL . '       1. Second indent list element 1'
            . PHP_EOL . '   - Again first indent list element 3'
            . PHP_EOL . '       - Alternate second level element 1'
            . PHP_EOL . '3. Sudden top level element.';

        $listBlock = ListBlock::tryCreate($input);

        self::assertInstanceOf(ListBlock::class, $listBlock);
        self::assertTrue($listBlock->isOrdered());

        $items = $listBlock->getItems();
        self::assertCount(4, $items);

        // First level assertions
        self::assertInstanceOf(ListItem::class, $items[0]);
        self::assertEquals('Top level element 1', $items[0]->getContent());

        self::assertInstanceOf(ListItem::class, $items[1]);
        self::assertEquals('Top level element 2', $items[1]->getContent());

        self::assertInstanceOf(ListItem::class, $items[3]);
        self::assertEquals('Sudden top level element.', $items[3]->getContent());

        self::assertInstanceOf(ListBlock::class, $items[2]);
        self::assertFalse($items[2]->isOrdered());
        $nestedLevel1 = $items[2]->getItems();
        self::assertCount(5, $nestedLevel1);

        // Second level assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel1[0]);
        self::assertEquals('First indent list element 1', $nestedLevel1[0]->getContent());

        self::assertInstanceOf(ListItem::class, $nestedLevel1[1]);
        self::assertEquals('First indent list element 2', $nestedLevel1[1]->getContent());

        self::assertInstanceOf(ListItem::class, $nestedLevel1[3]);
        self::assertEquals('Again first indent list element 3', $nestedLevel1[3]->getContent());

        self::assertInstanceOf(ListBlock::class, $nestedLevel1[2]);
        self::assertTrue($nestedLevel1[2]->isOrdered());
        $nestedLevel2a = $nestedLevel1[2]->getItems();
        self::assertCount(1, $nestedLevel2a);

        self::assertInstanceOf(ListBlock::class, $nestedLevel1[4]);
        self::assertFalse($nestedLevel1[4]->isOrdered());
        $nestedLevel2b = $nestedLevel1[4]->getItems();
        self::assertCount(1, $nestedLevel2b);

        // Third level assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel2a[0]);
        self::assertEquals('Second indent list element 1', $nestedLevel2a[0]->getContent());

        // Third level additional assertions
        self::assertInstanceOf(ListItem::class, $nestedLevel2b[0]);
        self::assertEquals('Alternate second level element 1', $nestedLevel2b[0]->getContent());
    }

    /**
     * Tests the tryCreate method for invalid list block
     */
    public function testTryCreateOnInvalidListBlock(): void
    {
        $invalidTestCases = [
            '# Unsupported list element',
            '. Unsupported list element',
            '2- Unsupported list element',
            '1- Unsupported list element',
            '1 Unsupported list element',
        ];

        foreach ($invalidTestCases as $input) {
            $listBlock = ListBlock::tryCreate($input);

            self::assertFalse($listBlock);
        }
    }
}
