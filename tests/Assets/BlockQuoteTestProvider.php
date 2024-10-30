<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Inline\Text;
use MethorZ\MarkMe\Element\Paragraph;

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
        $rootBlockQuote = new BlockQuote();
        $paragraph1 = new Paragraph();
        $paragraph1->addLine(new Text('Level 1 quote first paragraph'));
        $rootBlockQuote->addLine($paragraph1);

        $paragraph2 = new Paragraph();
        $paragraph2->addLine(new Text('Level 1 quote second paragraph'));
        $rootBlockQuote->addLine($paragraph2);

        $level2BlockQuote = new BlockQuote();
        $rootBlockQuote->addLine($level2BlockQuote);
        $paragraph3 = new Paragraph();
        $paragraph3->addLine(new Text('Level 2 quote first line'));
        $level2BlockQuote->addLine($paragraph3);

        $paragraph4 = new Paragraph();
        $paragraph4->addLine(new Text('Level 2 quote new paragraph'));
        $level2BlockQuote->addLine($paragraph4);

        $level3BlockQuote = new BlockQuote();
        $level2BlockQuote->addLine($level3BlockQuote);
        $paragraph5 = new Paragraph();
        $paragraph5->addLine(new Text('Level 3 quote first paragraph'));
        $level3BlockQuote->addLine($paragraph5);

        $paragraph6 = new Paragraph();
        $paragraph6->addLine(new Text('Level 3 quote second paragraph'));
        $paragraph6->addLine(new Text('Still level 3 same paragraph'));
        $level3BlockQuote->addLine($paragraph6);

        $paragraph7 = new Paragraph();
        $paragraph7->addLine(new Text('Back to level 2 in a new paragraph'));
        $level2BlockQuote->addLine($paragraph7);

        $level3BlockQuote2 = new BlockQuote();
        $level2BlockQuote->addLine($level3BlockQuote2);
        $paragraph8 = new Paragraph();
        $paragraph8->addLine(new Text('Going to level 3 again'));
        $level3BlockQuote2->addLine($paragraph8);

        $paragraph9 = new Paragraph();
        $paragraph9->addLine(new Text('Another paragraph at level 3'));
        $level3BlockQuote2->addLine($paragraph9);

        $paragraph10 = new Paragraph();
        $paragraph10->addLine(new Text('Back to level 2 once more'));
        $level2BlockQuote->addLine($paragraph10);

        $paragraph11 = new Paragraph();
        $paragraph11->addLine(new Text('And finally back to level 1'));
        $rootBlockQuote->addLine($paragraph11);

        $paragraph12 = new Paragraph();
        $paragraph12->addLine(new Text('A final paragraph at level 1 to wrap things up'));
        $rootBlockQuote->addLine($paragraph12);

        return [
            $rootBlockQuote,
        ];
    }
}
