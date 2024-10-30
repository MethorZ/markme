<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Attribute;

use MethorZ\MarkMe\Attribute\Attribute;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the attribute
 *
 * @package MethorZ\MarkMeTest\Attribute
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class AttributeTest extends TestCase
{
    /**
     * Test if the attribute is correctly identified as an ID
     */
    public function testIsId(): void
    {
        $attribute = new Attribute('#myId');

        self::assertTrue($attribute->isId());
        self::assertSame('myId', $attribute->getValue());
    }

    /**
     * Test if the attribute is correctly identified as a class
     */
    public function testIsClass(): void
    {
        $attribute = new Attribute('.myClass');

        self::assertTrue($attribute->isClass());
        self::assertSame('myClass', $attribute->getValue());
    }

    /**
     * Test if the attribute is correctly identified as a style
     */
    public function testIsStyle(): void
    {
        $attribute = new Attribute('style="color:red;"');

        self::assertTrue($attribute->isStyle());
        self::assertSame('color:red;', $attribute->getValue());
    }

    /**
     * Test if the attribute is correctly identified as a style with multiple properties
     */
    public function testIsStyleMultipleProperties(): void
    {
        $attribute = new Attribute('style="color:red; font-size:12px;"');

        self::assertTrue($attribute->isStyle());
        self::assertSame('color:red; font-size:12px;', $attribute->getValue());
    }

    /**
     * Test if the attribute is correctly identified as a key-value pair
     */
    public function testIsKeyValue(): void
    {
        $attribute = new Attribute('data-key="value"');

        self::assertTrue($attribute->isKeyValue());
        self::assertSame('data-key="value"', $attribute->getValue());
    }

    /**
     * Test if the attribute is not identified as an ID
     */
    public function testIsNotId(): void
    {
        $attribute = new Attribute('.myClass');

        self::assertFalse($attribute->isId());
    }

    /**
     * Test if the attribute is not identified as a class
     */
    public function testIsNotClass(): void
    {
        $attribute = new Attribute('#myId');

        self::assertFalse($attribute->isClass());
    }

    /**
     * Test if the attribute is not identified as a style
     */
    public function testIsNotStyle(): void
    {
        $attribute = new Attribute('data-key="value"');

        self::assertFalse($attribute->isStyle());
    }

    /**
     * Test if the attribute is not identified as a key-value pair
     */
    public function testIsNotKeyValue(): void
    {
        $attribute = new Attribute('#myId');

        self::assertFalse($attribute->isKeyValue());
    }
}
