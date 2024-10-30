<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Tests cases / expectations / elements provider for list blocks
 *
 * @package MethorZ\MarkMeTest\Assets
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ParagraphTestProvider
{
    /**
     * Create paragraphs for testing
     *
     * @return array<\MethorZ\MarkMe\Element\Paragraph>
     */
    public static function getElements(): array
    {
        /*
         * Build this markdown:
         *
         * This is a single line paragraph.
         *
         * This is a multiline paragraph.
         * Since it has multiple lines and is
         * therefore considered part of a single paragraph.
         *
         * This is also a multiline paragraph.<br />It has the html break character to create <br> multiple lines in a single <br/> paragraph.
         *
         */
        $paragraph1 = new Paragraph();
        $paragraph1->addLine(new Text('This is a single line paragraph.'));

        $paragraph2 = new Paragraph();
        $paragraph2->addLine(new Text('This is a multiline paragraph.'));
        $paragraph2->addLine(new Text('Since it has multiple lines and is'));
        $paragraph2->addLine(new Text('therefore considered part of a single paragraph.'));

        $paragraph3 = new Paragraph();
        $paragraph3->addLine(new Text('This is also a multiline paragraph.<br />It has the html break character to create<br>multiple lines in a single<br/>paragraph.'));

        return [
            $paragraph1,
            new NewLine(),
            $paragraph2,
            new NewLine(),
            $paragraph3,
        ];
    }
}
