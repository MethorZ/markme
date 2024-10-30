<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\Inline\Text;
use MethorZ\MarkMe\Element\NewLine;

/**
 * Tests cases / expectations / elements provider for list blocks
 *
 * @package MethorZ\MarkMeTest\Assets
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListBlockTestProvider
{
    /**
     * Create blockquotes for testing
     *
     * @return array<\MethorZ\MarkMe\Element\ListBlock>
     */
    public static function getElements(): array // phpcs:ignore
    {
        /*
         * Create this markdown:
         *
         * - Unordered Top Level Element 1
         * - Unordered Top Level Element 2
         */
        $listBlock1 = new ListBlock(false);
        $listBlock1->addItem(new ListItem(new Text('Unordered Top Level Element 1')));
        $listBlock1->addItem(new ListItem(new Text('Unordered Top Level Element 2')));

        /*
         * Create this markdown:
         *
         * 1. Ordered Top Level Element 1
         * 2. Ordered Top Level Element 2
         */
        $listBlock2 = new ListBlock(true);
        $listBlock2->addItem(new ListItem(new Text('Ordered Top Level Element 1')));
        $listBlock2->addItem(new ListItem(new Text('Ordered Top Level Element 2')));

        /*
         * Create this markdown:
         *
         * - Top Level Element 1
         * - Top Level Element 2
         *   1. First Indent List Element 1
         *   2. First Indent List Element 2
         *     - Second Indent List Element 1
         *   3. Again First Indent List Element 3
         *     - Alternate Second Level Element 1
         * - Sudden top level element.
         */
        $listBlock3 = new ListBlock(false);
        $listBlock3->addItem(new ListItem(new Text('Top Level Element 1')));
        $listBlock3->addItem(new ListItem(new Text('Top Level Element 2')));

        // Create first sub list and add it to the second top level element
        $subListBlock1 = new ListBlock(true);
        $listBlock3->addItem($subListBlock1);
        $subListBlock1->addItem(new ListItem(new Text('First Indent List Element 1')));
        $subListBlock1->addItem(new ListItem(new Text('First Indent List Element 2')));

        // Create second sub list and add it to the second top level element
        $subListBlock2 = new ListBlock(false);
        $subListBlock1->addItem($subListBlock2);
        $subListBlock2->addItem(new ListItem(new Text('Second Indent List Element 1')));

        $subListBlock1->addItem(new ListItem(new Text('Again First Indent List Element 3')));

        // Create third sub list and add it to the second top level element
        $subListBlock3 = new ListBlock(false);
        $subListBlock1->addItem($subListBlock3);
        $subListBlock3->addItem(new ListItem(new Text('Alternate Second Level Element 1')));

        // Add last item to the first sub list
        $listBlock3->addItem(new ListItem(new Text('Sudden top level element.')));

        return [
            $listBlock1,
            new NewLine(),
            $listBlock2,
            new NewLine(),
            $listBlock3,
        ];
    }
}
