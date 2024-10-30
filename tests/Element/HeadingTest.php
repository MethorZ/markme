<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Element\Heading;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the heading element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HeadingTest extends TestCase
{
    /**
     * Test heading element with valid markdown
     */
    public function testHeadingElements1To6WithValidMarkdown(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            $markdown = str_repeat('#', $i) . ' Heading ' . $i;
            $heading = Heading::tryCreate($markdown);

            self::assertSame('Heading ' . $i, $heading->getText()->getText());
            self::assertSame($i, $heading->getLevel());
        }
    }

    /**
     * Test heading element with invalid markdown
     */
    public function testHeadingWithNoSpacing(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            $markdown = str_repeat('#', $i) . 'Heading ' . $i;
            $heading = Heading::tryCreate($markdown);

            self::assertFalse($heading);
        }
    }

    /**
     * Test heading only with id attribute
     */
    public function testHeadingWithIdAttribute(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            $markdown = str_repeat('#', $i) . ' Heading ' . $i . ' {#heading-' . $i . '}';
            $heading = Heading::tryCreate($markdown);
            $checked = false;

            $attributes = $heading->getAttributes();

            self::assertSame('Heading ' . $i, $heading->getText()->getText());
            self::assertSame($i, $heading->getLevel());

            foreach ($attributes as $attribute) {
                if ($attribute->getType() === 'id') {
                    self::assertSame('heading-' . $i, $attribute->getValue());
                    $checked = true;
                }
            }

            self::assertTrue($checked);
        }
    }

    /**
     * Test heading only with class attribute
     */
    public function testHeadingWithClassAttribute(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            $markdown = str_repeat('#', $i) . ' Heading ' . $i . ' {.heading-' . $i . '}';
            $heading = Heading::tryCreate($markdown);
            $checked = false;

            $attributes = $heading->getAttributes();

            self::assertSame('Heading ' . $i, $heading->getText()->getText());
            self::assertSame($i, $heading->getLevel());

            foreach ($attributes as $attribute) {
                if ($attribute->getType() === 'class') {
                    self::assertSame('heading-' . $i, $attribute->getValue());
                    $checked = true;
                }
            }

            self::assertTrue($checked);
        }
    }

    /**
     * Test heading only with style attribute
     */
    public function testHeadingWithStyleAttribute(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            $markdown = str_repeat('#', $i) . ' Heading ' . $i . ' {style="color: red;"}';
            $heading = Heading::tryCreate($markdown);
            $checked = false;

            $attributes = $heading->getAttributes();

            self::assertSame('Heading ' . $i, $heading->getText()->getText());
            self::assertSame($i, $heading->getLevel());

            foreach ($attributes as $attribute) {
                if ($attribute->getType() === 'style') {
                    self::assertSame('color:red;', $attribute->getValue());
                    $checked = true;
                }
            }

            self::assertTrue($checked);
        }
    }

    /**
     * Test heading only with key-value attribute
     */
    public function testHeadingWithKeyValueAttribute(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            $markdown = str_repeat('#', $i) . ' Heading ' . $i . ' {attribute="my-attribute-value"}';
            $heading = Heading::tryCreate($markdown);
            $checked = false;

            $attributes = $heading->getAttributes();

            self::assertSame('Heading ' . $i, $heading->getText()->getText());
            self::assertSame($i, $heading->getLevel());

            foreach ($attributes as $attribute) {
                if ($attribute->getType() === 'key_value') {
                    self::assertSame('attribute="my-attribute-value"', $attribute->getValue());
                    $checked = true;
                }
            }

            self::assertTrue($checked);
        }
    }

    /**
     * Test for the heading 1-6 with attributes
     */
    public function testHeadingWithAttributes(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            $markdown = str_repeat('#', $i) . ' Heading ' . $i . ' {#heading-' . $i . ' .heading-' . $i . ' style="color: red;" attribute="my-attribute-value"}';
            $heading = Heading::tryCreate($markdown);
            $checkedId = false;
            $checkedClass = false;
            $checkedStyle = false;
            $checkedAttribute = false;

            $attributes = $heading->getAttributes();

            self::assertSame('Heading ' . $i, $heading->getText()->getText());
            self::assertSame($i, $heading->getLevel());

            foreach ($attributes as $attribute) {
                switch ($attribute->getType()) {
                    case 'id':
                        self::assertSame('heading-' . $i, $attribute->getValue());
                        $checkedId = true;

                        break;

                    case 'class':
                        self::assertSame('heading-' . $i, $attribute->getValue());
                        $checkedClass = true;

                        break;

                    case 'style':
                        self::assertSame('color:red;', $attribute->getValue());
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
}
