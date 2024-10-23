<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\TagRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the tag renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class TagRendererTest extends TestCase
{
    /**
     * Test for the tag rendering
     */
    public function testTagRendering(): void
    {
        $text = new Text('ThisIsATag');
        $tag = new Tag($text);

        $renderer = new TagRenderer();
        $html = $renderer->render($tag);

        self::assertEquals('<tag>#ThisIsATag</tag>', $html);
    }
}
