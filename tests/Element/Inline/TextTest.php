<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element\Inline;

use MethorZ\MarkMe\Element\Inline\Text;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the text element
 *
 * @package MethorZ\MarkMeTest\Element\Inline
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class TextTest extends TestCase
{
    /**
     * Test tryCreate method with valid markdown
     */
    public function testTryCreateWithValidMarkdown(): void
    {
        $markdown = 'This is a text';

        $text = new Text($markdown);

        self::assertInstanceOf(Text::class, $text);
        self::assertSame('This is a text', $text->getText());
    }

    /**
     * Test for the isBold check
     */
    public function testIsBold(): void
    {
        $text = new Text('**This is a bold text**');

        self::assertTrue($text->containsBoldMarkdown());
    }

    /**
     * Test for the isBold check
     */
    public function testIsNotBoldWithSingleAsterisk(): void
    {
        $text = new Text('*This is not a bold text*');

        self::assertFalse($text->containsBoldMarkdown());
    }

    /**
     * Test for the isBold check
     */
    public function testIsNotBoldWithThreeAsterisks(): void
    {
        $text = new Text('***This is not a bold text***');

        self::assertFalse($text->containsBoldMarkdown());
    }

    /**
     * Test for bold text inside of the text
     */
    public function testContainsBoldText(): void
    {
        $text = new Text('This is a text with **bold text** in it');

        self::assertTrue($text->containsBoldMarkdown());
    }

    /**
     * Test for the isItalic check
     */
    public function testIsItalic(): void
    {
        $text = new Text('*This is an italic text*');

        self::assertTrue($text->containsItalicMarkdown());
    }

    /**
     * Test for string contains italic text
     */
    public function testContainsItalicText(): void
    {
        $text = new Text('This is a text with *italic text* in it');

        self::assertTrue($text->containsItalicMarkdown());
    }

    /**
     * Test for the isItalic check
     */
    public function testIsNotItalicWithSingleAsterisk(): void
    {
        $text = new Text('**This is not an italic text**');

        self::assertFalse($text->containsItalicMarkdown());
    }

    /**
     * Test for the isItalic check
     */
    public function testIsNotItalicWithThreeAsterisks(): void
    {
        $text = new Text('***This is not an italic text***');

        self::assertFalse($text->containsItalicMarkdown());
    }

    /**
     * Test for the isStrikethrough check
     */
    public function testIsStrikethrough(): void
    {
        $text = new Text('~~This is a strikethrough text~~');

        self::assertTrue($text->containsStrikethroughMarkdown());
    }

    /**
     * Test text contains strikethrough text
     */
    public function testContainsStrikethroughText(): void
    {
        $text = new Text('This is a text with ~~strikethrough text~~ in it');

        self::assertTrue($text->containsStrikethroughMarkdown());
    }

    /**
     * Test for the isStrikethrough check
     */
    public function testIsNotStrikethroughWithSingleTilde(): void
    {
        $text = new Text('~This is not a strikethrough text~');

        self::assertFalse($text->containsStrikethroughMarkdown());
    }

    /**
     * Test for the isStrikethrough check
     */
    public function testIsNotStrikethroughWithThreeTildes(): void
    {
        $text = new Text('~~~This is not a strikethrough text~~~');

        self::assertFalse($text->containsStrikethroughMarkdown());
    }

    /**
     * Test for the isCode check
     */
    public function testIsCode(): void
    {
        $text = new Text('`This is a code text`');

        self::assertTrue($text->containsCodeMarkdown());
    }

    /**
     * Test for the isCode check
     */
    public function testIsNotCodeWithMultipleBacktick(): void
    {
        $text = new Text('``This is not a code text``');

        self::assertFalse($text->containsCodeMarkdown());
    }

    /**
     * Test for the subscript check
     */
    public function testIsSubscript(): void
    {
        $text = new Text('~This is a subscript text~');

        self::assertTrue($text->containsSubscriptMarkdown());
    }

    /**
     * Test text contains subscript text
     */
    public function testContainsSubscriptText(): void
    {
        $text = new Text('This is a text with ~subscript text~ in it');

        self::assertTrue($text->containsSubscriptMarkdown());
    }

    /**
     * Test for the subscript check
     */
    public function testIsNotSubscriptWithSingleTilde(): void
    {
        $text = new Text('~~This is not a subscript text~~');

        self::assertFalse($text->containsSubscriptMarkdown());
    }

    /**
     * Test for the superscript check
     */
    public function testIsSuperscript(): void
    {
        $text = new Text('^This is a superscript text^');

        self::assertTrue($text->containsSuperscriptMarkdown());
    }

    /**
     * Test text contains superscript text
     */
    public function testContainsSuperscriptText(): void
    {
        $text = new Text('This is a text with ^superscript text^ in it');

        self::assertTrue($text->containsSuperscriptMarkdown());
    }

    /**
     * Test for the superscript check
     */
    public function testIsNotSuperscriptWithSingleCaret(): void
    {
        $text = new Text('^^This is not a superscript text^^');

        self::assertFalse($text->containsSuperscriptMarkdown());
    }

    /**
     * Test for the isUnderlined check
     */
    public function testIsUnderlined(): void
    {
        $text = new Text('__This is an underlined text__');

        self::assertTrue($text->containsUnderlinedMarkdown());
    }

    /**
     * Test text contains underlined text
     */
    public function testContainsUnderlinedText(): void
    {
        $text = new Text('This is a text with __underlined text__ in it');

        self::assertTrue($text->containsUnderlinedMarkdown());
    }

    /**
     * Test for the isUnderlined check
     */
    public function testIsNotUnderlinedWithSingleU(): void
    {
        $text = new Text('_This is not an underlined text_');

        self::assertFalse($text->containsUnderlinedMarkdown());
    }

    /**
     * Test for the isUnderlined check
     */
    public function testIsNotUnderlinedWithThreeUs(): void
    {
        $text = new Text('___This is not an underlined text___');

        self::assertFalse($text->containsUnderlinedMarkdown());
    }

    /**
     * Test if the text is an image
     */
    public function testIsImage(): void
    {
        $text = new Text('![This is an image](https://example.com/image.jpg)');

        self::assertTrue($text->containsImage());
    }

    /**
     * Test if the text is an image
     */
    public function testIsNotImageWithoutExclamationMark(): void
    {
        $text = new Text('[This is not an image](https://example.com/image.jpg)');

        self::assertFalse($text->containsImage());
    }

    /**
     * Test if the text is an image
     */
    public function testIsNotImageWithoutSquareBrackets(): void
    {
        $text = new Text('!This is not an image(https://example.com/image.jpg)');

        self::assertFalse($text->containsImage());
    }

    /**
     * Test if the text is an image
     */
    public function testIsNotImageWithoutRoundBrackets(): void
    {
        $text = new Text('![This is not an image]https://example.com/image.jpg');

        self::assertFalse($text->containsImage());
    }

    /**
     * Test if the text is an image
     */
    public function testIsNotImageWithoutAltText(): void
    {
        $text = new Text('![]https://example.com/image.jpg');

        self::assertFalse($text->containsImage());
    }

    /**
     * Test if the text contains an image
     */
    public function testContainsImage(): void
    {
        $text = new Text('This is a text with an image ![image](https://example.com/image.jpg) in it');

        self::assertTrue($text->containsImage());
    }

    /**
     * Test if the text is a link
     */
    public function testIsLink(): void
    {
        $text = new Text('[This is a link](https://example.com)');

        self::assertTrue($text->containsLink());
    }

    /**
     * Test if the text is a link
     */
    public function testIsNotLinkWithoutSquareBrackets(): void
    {
        $text = new Text('This is not a link](https://example.com)');

        self::assertFalse($text->containsLink());
    }

    /**
     * Test if the text is a link
     */
    public function testIsNotLinkWithoutRoundBrackets(): void
    {
        $text = new Text('[This is not a link]https://example.com');

        self::assertFalse($text->containsLink());
    }

    /**
     * Test if the text is a link
     */
    public function testIsLinkWithoutAltText(): void
    {
        $text = new Text('[](https://example.com)');

        self::assertTrue($text->containsLink());
    }

    /**
     * Test if the text is a link
     */
    public function testIsNotLinkWithoutUrl(): void
    {
        $text = new Text('[This is not a link]');

        self::assertFalse($text->containsLink());
    }

    /**
     * Test if the text is a link
     */
    public function testIsLinkWithImage(): void
    {
        $text = new Text('[![An old rock in the desert](/assets/images/shiprock.jpg "Shiprock, New Mexico by Beau Rogers")](https://www.example.com/)');
        self::assertTrue($text->containsLink());
    }

    /**
     * Test if the text contains a link
     */
    public function testContainsLink(): void
    {
        $text = new Text('This is a text with a link [link](https://example.com) in it');

        self::assertTrue($text->containsLink());
    }

    /**
     * Test if the text contains a link with an image
     */
    public function testContainsLinkWithImage(): void
    {
        $text = new Text(
            'This is a text with a link [![An old rock in the desert](/assets/images/shiprock.jpg "Shiprock, New Mexico by Beau Rogers")](https://www.example.com/) in it'
        );

        self::assertTrue($text->containsLink());
    }

    /**
     * Test if the text contains a tag
     */
    public function testContainsTag(): void
    {
        $text = new Text('This is a text with a tag #ThisIsATag in it');

        self::assertTrue($text->containsTag());
    }
}
