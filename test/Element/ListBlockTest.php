<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\ListBlockRenderer;
use MethorZ\MarkMe\Renderer\ListItemRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
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
     * Test for the list block rendering
     */
    public function testUnorderedListBlockRendering(): void
    {
        $expectedOutput = '<ul><li>Item 1</li><li>Item 2</li></ul>';

        $listBlock = new ListBlock(false, 0);
        $listBlock->addItem(new ListItem(new Text('Item 1')));
        $listBlock->addItem(new ListItem(new Text('Item 2')));

        $listBlockRenderer = new ListBlockRenderer(new ListItemRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer())));
        $output = $listBlockRenderer->render($listBlock);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the list block rendering
     */
    public function testOrderedListBlockRendering(): void
    {
        $expectedOutput = '<ol><li>Item 1</li><li>Item 2</li></ol>';

        $listBlock = new ListBlock(true, 0);
        $listBlock->addItem(new ListItem(new Text('Item 1')));
        $listBlock->addItem(new ListItem(new Text('Item 2')));

        $listBlockRenderer = new ListBlockRenderer(new ListItemRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer())));
        $output = $listBlockRenderer->render($listBlock);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the nested list block rendering
     */
    public function testNestedListBlockRendering(): void
    {
        $deeplyNestedList = new ListBlock(false, 2);
        $deeplyNestedList->addItem(new ListItem(new Text('Deeply nested list item 1')));
        $deeplyNestedList->addItem(new ListItem(new Text('Deeply nested list item 2')));
        $deeplyNestedList->addItem(new ListItem(new Text('Deeply nested list item 3')));

        $nestedList = new ListBlock(false, 1);
        $nestedList->addItem(new ListItem(new Text('Sub list item 1')));
        $nestedList->addItem($deeplyNestedList);
        $nestedList->addItem(new ListItem(new Text('Sub list item 3')));

        $listBlock = new ListBlock(false, 0);
        $listBlock->addItem(new ListItem(new Text('Item 1')));
        $listBlock->addItem($nestedList);
        $listBlock->addItem(new ListItem(new Text('Item 3')));

        $expectedOutput = '<ul><li>Item 1</li><li><ul><li>Sub list item 1</li><li><ul><li>Deeply nested list item 1</li><li>Deeply nested list item 2</li><li>Deeply nested list item 3</li></ul></li><li>Sub list item 3</li></ul></li><li>Item 3</li></ul>';

        $listBlockRenderer = new ListBlockRenderer(new ListItemRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer())));
        $output = $listBlockRenderer->render($listBlock);

        self::assertEquals($expectedOutput, $output);
    }
}
