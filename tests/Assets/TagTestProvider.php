<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Attribute\Attribute;
use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\Inline\Text;

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
        $idAttribute = new Attribute('#tagId');
        $classAttribute = new Attribute('.tagClass');
        $styleAttribute = new Attribute('style="color: red;"');
        $dataAttribute = new Attribute('data-attribute=my-attribute-value');
        $dataAttribute2 = new Attribute('data-attribute="my-attribute-value"');

        $tagWithAttribute1 = new Tag(new Text('TagWithAttribute1'));
        $tagWithAttribute1->addAttribute($idAttribute);

        $tagWithAttribute2 = new Tag(new Text('TagWithAttribute2'));
        $tagWithAttribute2->addAttribute($classAttribute);

        $tagWithAttribute3 = new Tag(new Text('TagWithAttribute3'));
        $tagWithAttribute3->addAttribute($styleAttribute);

        $tagWithAttribute4 = new Tag(new Text('TagWithAttribute4'));
        $tagWithAttribute4->addAttribute($dataAttribute);

        $tagWithAttribute5 = new Tag(new Text('TagWithAttribute5'));
        $tagWithAttribute5->addAttribute($dataAttribute2);

        $tagWithMultipleAttributes = new Tag(new Text('TagWithMultipleAttributes'));
        $tagWithMultipleAttributes->addAttribute($idAttribute);
        $tagWithMultipleAttributes->addAttribute($classAttribute);
        $tagWithMultipleAttributes->addAttribute($styleAttribute);
        $tagWithMultipleAttributes->addAttribute($dataAttribute);

        return [
            new Tag(new Text('ThisIsATag')),
            new Tag(new Text('TagWithNumberAtEnd1')),
            new Tag(new Text('TagWith1NumberIn')),
            new Tag(new Text('1TagWithNumberAtStart')),
            $tagWithAttribute1,
            $tagWithAttribute2,
            $tagWithAttribute3,
            $tagWithAttribute4,
            $tagWithAttribute5,
            $tagWithMultipleAttributes,
        ];
    }
}
