<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Element;

use MethorZ\MarkMe\Attribute\Attribute;
use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Renderer\HeadingRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Heading element
 *
 * @package MethorZ\MarkMeTest\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HeadingTest extends TestCase
{
    /**
     * Test for the heading 1-6 rendering
     */
    public function testHeading1Rendering(): void
    {
        for ($level = 1; $level <= 6; $level++) {

            $text = 'This is a heading ' . $level;
            $heading = new Heading(new Text($text), $level);

            $renderer = new HeadingRenderer();
            $rendered = $renderer->render($heading);

            self::assertEquals('<h' . $level . '>' . $text . '</h' . $level . '>', $rendered);
        }
    }

    /**
     * Test for the heading 1-6 rendering with attributes
     */
    public function testHeading1RenderingWithAttributes(): void
    {
        for ($level = 1; $level <= 6; $level++) {

            $text = 'This is a heading ' . $level;
            $heading = new Heading(new Text($text), $level);
            $heading->addAttribute(new Attribute('#heading-' . $level));
            $heading->addAttribute(new Attribute('.heading-' . $level));
            $heading->addAttribute(new Attribute('style="color: red;"'));
            $heading->addAttribute(new Attribute('attribute="my-attribute-value"'));

            $renderer = new HeadingRenderer();
            $rendered = $renderer->render($heading);

            self::assertEquals('<h' . $level . ' id="heading-' . $level . '" class="heading-' . $level . '" style="color:red;" attribute="my-attribute-value">' . $text . '</h' . $level . '>', $rendered);
        }
    }

    /**
     * Test for matching the markdown string
     */
    public function testHeadingMatching(): void
    {
        for ($level = 1; $level <= 6; $level++) {

            $text = 'This is a heading ' . $level;
            $markdown = str_repeat('#', $level) . ' ' . $text;

            $heading = Heading::tryCreate($markdown);

            self::assertNotNull($heading);
            self::assertNotFalse($heading);
            self::assertEquals($text, $heading->getText()->getText());
            self::assertEquals($level, $heading->getLevel());
        }
    }

    /**
     * Test for matching when heading has optional curly braces at the end
     */
    public function testHeadingMatchingWithCurlyBraces(): void
    {
        for ($level = 1; $level <= 6; $level++) {

            $text = 'This is a heading ' . $level;
            $markdown = str_repeat('#', $level) . ' ' . $text . ' { #heading-' . $level . ' .heading-' . $level . ' style="color: red;" attribute=my-attribute-value }';

            $heading = Heading::tryCreate($markdown);

            // Check the attributes parsed
            foreach ($heading->getAttributes() as $attribute) {
                if ($attribute->isId()) {
                    self::assertEquals('heading-' . $level, $attribute->getValue());
                } elseif ($attribute->isClass()) {
                    self::assertEquals('heading-' . $level, $attribute->getValue());
                } elseif ($attribute->isStyle()) {
                    self::assertEquals('color:red;', $attribute->getValue());
                } elseif ($attribute->isKeyValue()) {
                    self::assertEquals('attribute=my-attribute-value', $attribute->getValue());
                }
            }
        }
    }
}
