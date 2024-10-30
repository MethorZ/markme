<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Tests cases / expectations / elements provider for blockquotes
 *
 * @package MethorZ\MarkMeTest\Assets
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuoteTestProvider
{
    /**
     * Create blockquotes for testing
     *
     * @return array<\MethorZ\MarkMe\Element\BlockQuote>
     */
    public static function getElements(): array // phpcs:ignore
    {
        /*
         * Build this markdown:
         *
         * > This is an example of a blockquote.
         */
        $blockQuote1 = new BlockQuote();
        $blockQuote1->addLine(new Text('This is an example of a blockquote.'));

        /*
         * Build this markdown:
         *
         * > This is an example of a multiline blockquote.
         * > It consists of three lines of blockquote text.
         * > This is the last line of the blockquote text.
         */
        $blockQuote2 = new BlockQuote();
        $blockQuote2->addLine(new Text('This is an example of a multiline blockquote.'));
        $blockQuote2->addLine(new Text('It consists of three lines of blockquote text.'));
        $blockQuote2->addLine(new Text('This is the last line of the blockquote text.'));

        /*
         * Build this markdown:
         *
         * > This is an example of a multiline nested blockquote.
         * > The first two lines are the first (top) level elements.
         * >> This is the second level of the nested blockquote.
         * >> Followed by this second line of nested blockquote on the second level.
         * >>> This is the third level of nested blockquote as a single line.
         * >> We are now adding a second independent second level blockquote.
         * >>> Additionally, nesting a third level blockquote.
         * > Last but not least we are back to the first level blockquote now.
         */
        $blockQuote3 = new BlockQuote();
        $blockQuote3->addLine(new Text('This is an example of a multiline nested blockquote.'));
        $blockQuote3->addLine(new Text('The first two lines are the first (top) level elements.'));

        // Create the second level blockquote and add it directly to the first level blockquote
        $secondLevelBlockquote1 = new BlockQuote();
        $blockQuote3->addLine($secondLevelBlockquote1);
        $secondLevelBlockquote1->addLine(new Text('This is the second level of the nested blockquote.'));
        $secondLevelBlockquote1->addLine(new Text('Followed by this second line of nested blockquote on the second level.'));

        // Create the first third level blockquote and add it to the second level blockquote
        $thirdLevelBlockquote1 = new BlockQuote();
        $secondLevelBlockquote1->addLine($thirdLevelBlockquote1);
        $thirdLevelBlockquote1->addLine(new Text('This is the third level of nested blockquote as a single line.'));

        // Add the next second level line to the corresponding blockquote
        $secondLevelBlockquote1->addLine(new Text('We are now adding a second independent second level blockquote.'));

        // Create the second third level blockquote and add it to the second level blockquote
        $thirdLevelBlockquote2 = new BlockQuote();
        $secondLevelBlockquote1->addLine($thirdLevelBlockquote2);
        $thirdLevelBlockquote2->addLine(new Text('Additionally, nesting a third level blockquote.'));

        // Add the last first level line to the corresponding blockquote
        $blockQuote3->addLine(new Text('Last but not least we are back to the first level blockquote now.'));

        return [
            $blockQuote1,
            $blockQuote2,
            $blockQuote3,
        ];
    }
}
