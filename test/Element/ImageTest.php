<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Attribute\Attribute;
use MethorZ\MarkMe\Element\Image;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Image element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ImageTest extends TestCase
{
    /**
     * Test for the image rendering
     */
    public function testImageSourceRendering(): void
    {
        $image = 'https://example.com/image.jpg';
        $expectedOutput = '<img src="' . $image . '" />';

        $image = new Image($image);

        $imageRenderer = new ImageRenderer();
        $output = $imageRenderer->render($image);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the image rendering with attributes
     */
    public function testImageSourceWithAttributesRendering(): void
    {
        $imageUrl = 'https://example.com/image.jpg';
        $expectedOutput = '<img src="' . $imageUrl . '" id="my-id" class="my-class" style="color:red;" attribute="my-attribute-value" />';

        $image = new Image($imageUrl);
        $image->addAttribute(new Attribute('#my-id'));
        $image->addAttribute(new Attribute('.my-class'));
        $image->addAttribute(new Attribute('style="color:red;"'));
        $image->addAttribute(new Attribute('attribute="my-attribute-value"'));

        $imageRenderer = new ImageRenderer();
        $output = $imageRenderer->render($image);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the image rendering with alt text
     */
    public function testImageSourceWithAltTextRendering(): void
    {
        $image = 'https://example.com/image.jpg';
        $altText = 'Alt Text';
        $expectedOutput = '<img src="' . $image . '" alt="' . $altText . '" />';

        $image = new Image($image, $altText);

        $imageRenderer = new ImageRenderer();
        $output = $imageRenderer->render($image);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the image rendering with title
     */
    public function testImageSourceWithTitleRendering(): void
    {
        $image = 'https://example.com/image.jpg';
        $title = 'Title';
        $expectedOutput = '<img src="' . $image . '" title="' . $title . '" />';

        $image = new Image($image, null, $title);

        $imageRenderer = new ImageRenderer();
        $output = $imageRenderer->render($image);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for the image rendering with alt text and title
     */
    public function testImageSourceWithAltTextAndTitleRendering(): void
    {
        $image = 'https://example.com/image.jpg';
        $altText = 'Alt Text';
        $title = 'Title';
        $expectedOutput = '<img src="' . $image . '" alt="' . $altText . '" title="' . $title . '" />';

        $image = new Image($image, $altText, $title);

        $imageRenderer = new ImageRenderer();
        $output = $imageRenderer->render($image);

        self::assertEquals($expectedOutput, $output);
    }

    /**
     * Test for matching the markdown string with curly braces at the end
     */
    public function testImageMatchingWithCurlyBraces(): void
    {
        $markdown = '![Alt Text](https://example.com/image.jpg "Title"){ #my-id .my-class style="color: red;" attribute=my-attribute-value }';

        $image = Image::tryCreate($markdown);

        // Check the attributes parsed
        // Check the attributes parsed
        foreach ($image->getAttributes() as $attribute) {
            if ($attribute->isId()) {
                self::assertEquals('my-id', $attribute->getValue());
            } elseif ($attribute->isClass()) {
                self::assertEquals('my-class', $attribute->getValue());
            } elseif ($attribute->isStyle()) {
                self::assertEquals('color:red;', $attribute->getValue());
            } elseif ($attribute->isKeyValue()) {
                self::assertEquals('attribute=my-attribute-value', $attribute->getValue());
            }
        }
    }
}
