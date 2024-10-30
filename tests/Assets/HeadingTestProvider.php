<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Attribute\Attribute;
use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\Inline\Text;
use MethorZ\MarkMe\Element\NewLine;

/**
 * Tests cases / expectations / elements provider for headings
 *
 * @package MethorZ\MarkMeTest\Assets
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HeadingTestProvider
{
    /**
     * Create headings for testing
     *
     * @return array<\MethorZ\MarkMe\Element\Heading>
     */
    public static function getElements(): array // phpcs:ignore
    {
        /*
         * Build this markdown:
         *
         * # Heading 1 {#heading-1}
         * ## Heading 2 {.heading-1}
         *
         * ### Heading 3 {style="color: red;"}
         *
         * #### Heading 4 {attribute="my-attribute-value"}
         * ##### Heading 5 {#heading-1 .heading-1 style="color: red;" attribute="my-attribute-value"}
         * ###### Heading 6
         */
        $heading1 = new Heading(new Text('Heading 1'), 1);
        $heading1->addAttribute(new Attribute('#heading-1'));

        $heading2 = new Heading(new Text('Heading 2'), 2);
        $heading2->addAttribute(new Attribute('.heading-1'));

        $heading3 = new Heading(new Text('Heading 3'), 3);
        $heading3->addAttribute(new Attribute('style="color: red;"'));

        $heading4 = new Heading(new Text('Heading 4'), 4);
        $heading4->addAttribute(new Attribute('attribute=my-attribute-value'));

        $heading5 = new Heading(new Text('Heading 5'), 5);
        $heading5->addAttribute(new Attribute('#heading-1'));
        $heading5->addAttribute(new Attribute('.heading-1'));
        $heading5->addAttribute(new Attribute('style="color: red;"'));
        $heading5->addAttribute(new Attribute('attribute="my-attribute-value"'));

        $heading6 = new Heading(new Text('Heading 6'), 6);

        return [
            $heading1,
            $heading2,
            new NewLine(),
            $heading3,
            new NewLine(),
            $heading4,
            $heading5,
            $heading6,
        ];
    }
}
