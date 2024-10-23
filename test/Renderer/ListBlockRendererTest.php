<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

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
 * Tests for the list block renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListBlockRendererTest extends TestCase
{
    private ListBlockRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new ListBlockRenderer(new ListItemRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer())));
    }

    /**
     * Test for the unordered list block rendering
     */
    public function testUnorderedListBlockRendering(): void
    {
        $item1 = new ListItem(new Text('Item 1'));
        $item2 = new ListItem(new Text('Item 2'));
        $listBlock = new ListBlock(false, 0);
        $listBlock->addItem($item1);
        $listBlock->addItem($item2);

        $html = $this->renderer->render($listBlock);

        self::assertEquals('<ul><li>Item 1</li><li>Item 2</li></ul>', $html);
    }

    /**
     * Test for the ordered list block rendering
     */
    public function testOrderedListBlockRendering(): void
    {
        $item1 = new ListItem(new Text('Item 1'));
        $item2 = new ListItem(new Text('Item 2'));
        $listBlock = new ListBlock(true, 0);
        $listBlock->addItem($item1);
        $listBlock->addItem($item2);

        $html = $this->renderer->render($listBlock);

        self::assertEquals('<ol><li>Item 1</li><li>Item 2</li></ol>', $html);
    }
}
