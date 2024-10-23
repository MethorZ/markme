<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\ListItemRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
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
     * Test for the list item rendering
     */
    public function testListItemRendering(): void
    {
        $content = 'This is a list item.';
        $expectedOutput = '<li>' . $content . '</li>';

        $listItem = new ListItem(new Text($content));

        $listItemRenderer = new ListItemRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer()));
        $output = $listItemRenderer->render($listItem);

        self::assertEquals($expectedOutput, $output);
    }
}
