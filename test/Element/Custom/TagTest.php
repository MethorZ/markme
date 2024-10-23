<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element\Custom;

use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\TagRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the tag element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class TagTest extends TestCase
{
    /**
     * Test for rendering the tag
     */
    public function testTagRendering(): void
    {
        $text = new Text('ThisIsATag');
        $tag = new Tag($text);

        $renderer = new TagRenderer();
        $html = $renderer->render($tag);

        self::assertEquals('<tag>#ThisIsATag</tag>', $html);
    }

    /**
     * Test for matching the tag based on a list of valid tags
     */
    public function testValidTagMatching(): void
    {
        $validTags = [
            '#tag',
            '#tag1',
            '#1tag',
            '#tag12g',
            '#tag{test}',
            '#tag<br>',
            '#tag<br />',
            '#tag<br/>',
        ];

        foreach ($validTags as $validTag) {
            $tag = Tag::tryCreate($validTag);
            self::assertInstanceOf(Tag::class, $tag);
        }
    }

    /**
     * Test for not matching the tag based on a list of invalid tags
     */
    public function testInvalidTagMatching(): void
    {
        $invalidTags = [
            'tag',
            'tag1',
            'tag-1',
            'tag_1',
            'tag_1-1',
            'tag_!"§$%%&/())=1',
            '# tag',
            '# tag1',
            '# tag-1',
            '# tag_1',
            '# tag_1-1',
            '# tag_!"§$%%&/())=1',
            '#  tag',
            '#123123',
            '"#"', # links
            '"#anchor"', # anchor
            "'#anchor'", # anchor
        ];

        foreach ($invalidTags as $invalidTag) {
            $tag = Tag::tryCreate($invalidTag);
            self::assertFalse($tag);
        }
    }
}
