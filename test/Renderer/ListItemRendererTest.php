<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\ListItemRenderer;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the list item renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListItemRendererTest extends TestCase
{
    /**
     * Test for the list item rendering
     */
    public function testListItemRendering(): void
    {
        $text = new Text('This is a list item.');
        $listItem = new ListItem($text);

        $renderer = new ListItemRenderer(new TextRenderer(new ImageRenderer(), new TagRenderer()));
        $html = $renderer->render($listItem);

        self::assertEquals('<li>This is a list item.</li>', $html);
    }
}
