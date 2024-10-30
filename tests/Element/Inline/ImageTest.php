<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element\Inline;

use MethorZ\MarkMe\Element\Inline\Image;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Image element
 *
 * @package MethorZ\MarkMeTest\Element\Inline
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ImageTest extends TestCase
{
    /**
     * Test the tryCreate image element
     */
    public function testImageElement(): void
    {
        $image = Image::tryCreate('![The San Juan Mountains are beautiful!](/assets/images/san-juan-mountains.jpg "San Juan Mountains")');

        self::assertInstanceOf(Image::class, $image);
        self::assertEquals('/assets/images/san-juan-mountains.jpg', $image->getSource());
        self::assertEquals('The San Juan Mountains are beautiful!', $image->getAlt());
        self::assertEquals('San Juan Mountains', $image->getTitle());
    }

    /**
     * Test the tryCreate image element without title
     */
    public function testImageElementWithoutTitle(): void
    {
        $image = Image::tryCreate('![The San Juan Mountains are beautiful!](/assets/images/san-juan-mountains.jpg)');

        self::assertInstanceOf(Image::class, $image);
        self::assertEquals('/assets/images/san-juan-mountains.jpg', $image->getSource());
        self::assertEquals('The San Juan Mountains are beautiful!', $image->getAlt());
        self::assertNull($image->getTitle());
    }

    /**
     * Test the tryCreate image element without alt text
     */
    public function testImageElementWithoutAlt(): void
    {
        $image = Image::tryCreate('![](/assets/images/san-juan-mountains.jpg "San Juan Mountains")');

        self::assertInstanceOf(Image::class, $image);
        self::assertEquals('/assets/images/san-juan-mountains.jpg', $image->getSource());
        self::assertEmpty($image->getAlt());
        self::assertEquals('San Juan Mountains', $image->getTitle());
    }

    /**
     * Test the tryCreate image element without alt text and title
     */
    public function testImageElementWithoutAltAndTitle(): void
    {
        $image = Image::tryCreate('![](/assets/images/san-juan-mountains.jpg)');

        self::assertInstanceOf(Image::class, $image);
        self::assertEquals('/assets/images/san-juan-mountains.jpg', $image->getSource());
        self::assertEmpty($image->getAlt());
        self::assertNull($image->getTitle());
    }

    /**
     * Test for the heading 1-6 with attributes
     */
    public function testHeadingWithAttributes(): void
    {
        $markdown = '![The San Juan Mountains are beautiful!](/assets/images/san-juan-mountains.jpg "San Juan Mountains") {#image-1 .image-class style="width: 100%;" attribute="my-attribute-value"}';

        $image = Image::tryCreate($markdown);
        $checkedId = false;
        $checkedClass = false;
        $checkedStyle = false;
        $checkedAttribute = false;

        $attributes = $image->getAttributes();

        self::assertInstanceOf(Image::class, $image);
        self::assertEquals('/assets/images/san-juan-mountains.jpg', $image->getSource());
        self::assertEquals('The San Juan Mountains are beautiful!', $image->getAlt());
        self::assertEquals('San Juan Mountains', $image->getTitle());

        foreach ($attributes as $attribute) {
            switch ($attribute->getType()) {
                case 'id':
                    self::assertSame('image-1', $attribute->getValue());
                    $checkedId = true;

                    break;

                case 'class':
                    self::assertSame('image-class', $attribute->getValue());
                    $checkedClass = true;

                    break;

                case 'style':
                    self::assertSame('width:100%;', $attribute->getValue());
                    $checkedStyle = true;

                    break;

                case 'key_value':
                    self::assertSame('attribute="my-attribute-value"', $attribute->getValue());
                    $checkedAttribute = true;

                    break;
            }
        }

        self::assertTrue($checkedId);
        self::assertTrue($checkedClass);
        self::assertTrue($checkedStyle);
        self::assertTrue($checkedAttribute);
    }
}
