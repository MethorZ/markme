<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

use ArrayIterator;
use Iterator;
use MethorZ\MarkMe\Element\Inline\Text;
use MethorZ\MarkMe\Exception\ParseException;

/**
 * Blockquote element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuote extends AbstractElement
{
    private const string REGEX = '/^>{1,}\s(.*)$/';
    private const string VALID_MARKDOWN_REGEX = '/^>{1,}\s.*$/m';

    /**
     * Supported element features
     *
     * @var array<string>
     */
    protected static array $features = [
        ElementFeature::SUPPORTS_NESTING,
        ElementFeature::SUPPORTS_MULTI_LINE,
    ];

    /**
     * Quote lines
     *
     * @var array<\MethorZ\MarkMe\Element\Blockquote|\MethorZ\MarkMe\Element\Inline\Text>
     */
    private array $lines = [];

    /**
     * Add quote lines whether it is a string or another nested BlockQuote
     */
    public function addLine(Text|self $line): void
    {
        $this->lines[] = $line;
    }

    /**
     * Returns the heading text
     *
     * @return array<string|\MethorZ\MarkMe\Element\Blockquote>
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array
    {
        return [
            'lines' => $this->lines,
        ];
    }

    /**
     * Checks if the line matches the element and returns an instance of the element or false
     *
     * @throws \MethorZ\MarkMe\Exception\ParseException
     */
    public static function tryCreate(string $markdown): bool|self
    {
        if (!preg_match(self::VALID_MARKDOWN_REGEX, $markdown)) {

            if (!($markdown === '>')) {
                return false;
            }
        }

        $lines = explode(PHP_EOL, $markdown);
        $rootBlockQuote = new self();

        self::parseLines(new ArrayIterator($lines), $rootBlockQuote, 1);

        return $rootBlockQuote;
    }

    /**
     *  Parse the lines and create the nested BlockQuote elements
     *
     * Manual Iterator handling for passing by reference across recursive loops
     *
     * @throws \MethorZ\MarkMe\Exception\ParseException
     */
    private static function parseLines(Iterator $lines, self $currentBlockQuote, int $level): void
    {
        do {
            $line = $lines->current();

            // ToDo: Implementation of a new paragraph during rendering - skip for now
            if ($line === '>') {
                $lines->next();

                continue;
            }

            if (preg_match(self::REGEX, $line, $matches)) {
                $currentLevel = substr_count($line, '>');
                $text = trim($matches[1]);

                if ($currentLevel > $level) {
                    $newBlockQuote = new self();
                    $currentBlockQuote->addLine($newBlockQuote);
                    self::parseLines($lines, $newBlockQuote, $currentLevel);
                } elseif ($currentLevel < $level) {
                    return;
                } else {
                    $currentBlockQuote->addLine(new Text($text));
                    $lines->next();
                }
            } else {
                throw new ParseException('Invalid blockquote line: ' . $line);
            }
        } while ($lines->valid());
    }
}
