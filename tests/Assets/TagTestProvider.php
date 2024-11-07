<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Element\Inline\Text;
use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Element\Paragraph;

/**
 * Tests cases / expectations / elements provider for tags
 *
 * @package MethorZ\MarkMeTest\Assets
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class TagTestProvider
{
    /**
     * Create tags for testing
     *
     * @return array<\MethorZ\MarkMe\Element\Custom\Tag>
     */
    public static function getElements(): array
    {
        /*
         * #ThisIsATag
         * #TagWithNumberAtEnd1
         *
         * #TagWith1NumberIn
         *
         * #1TagWithNumberAtStart
         *
         * #TagWithSpecialChar{test}
         *
         * #TagWithAttribute1{#tagId}
         * #TagWithAttribute2{.tagClass}
         * #TagWithAttribute3{style="color: red;"}
         * #TagWithAttribute4{attribute=my-attribute-value}
         * #TagWithMultipleAttributes{#tagId .tagClass style="color: red;" attribute="my-attribute-value"}
         */

        $tag1 = new Paragraph();
        $tag1->addLine(new Text('#ThisIsATag'));

        $tag2 = new Paragraph();
        $tag2->addLine(new Text('#TagWithNumberAtEnd1'));

        $tag3 = new Paragraph();
        $tag3->addLine(new Text('#TagWith1NumberIn'));

        $tag4 = new Paragraph();
        $tag4->addLine(new Text('#1TagWithNumberAtStart'));

        $tagWithAttribute1 = new Paragraph();
        $tagWithAttribute1->addLine(new Text('#TagWithAttribute1{#tagId}'));

        $tagWithAttribute2 = new Paragraph();
        $tagWithAttribute2->addLine(new Text('#TagWithAttribute2{.tagClass}'));

        $tagWithAttribute3 = new Paragraph();
        $tagWithAttribute3->addLine(new Text('#TagWithAttribute3{style="color: red;"}'));

        $tagWithAttribute4 = new Paragraph();
        $tagWithAttribute4->addLine(new Text('#TagWithAttribute4{data-attribute=my-attribute-value}'));

        $tagWithAttribute5 = new Paragraph();
        $tagWithAttribute5->addLine(new Text('#TagWithAttribute5{data-attribute="my-attribute-value"}'));

        $tagWithMultipleAttributes = new Paragraph();
        $tagWithMultipleAttributes->addLine(new Text('#TagWithMultipleAttributes{#tagId .tagClass style="color: red;" data-attribute=my-attribute-value}'));

        $tagWithText = new Paragraph();
        $tagWithText->addLine(new Text('This is some text with a tag #ThisIsATag in between.'));

        $tagWithTextAndAttributes = new Paragraph();
        $tagWithTextAndAttributes->addLine(new Text('This is some text with a tag with attributes #ThisIsATag{#tagId .tagClass style="color: red;" data-attribute=my-attribute-value} in between.')); // phpcs:ignore

        return [
            $tag1,
            new NewLine(),
            $tag2,
            new NewLine(),
            $tag3,
            new NewLine(),
            $tag4,
            new NewLine(),
            $tagWithAttribute1,
            new NewLine(),
            $tagWithAttribute2,
            new NewLine(),
            $tagWithAttribute3,
            new NewLine(),
            $tagWithAttribute4,
            new NewLine(),
            $tagWithAttribute5,
            new NewLine(),
            $tagWithMultipleAttributes,
            new NewLine(),
            $tagWithText,
            new NewLine(),
            $tagWithTextAndAttributes,
        ];
    }
}
