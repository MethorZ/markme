<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

use ArrayIterator;
use Iterator;
use MethorZ\MarkMe\Element\Inline\Text;
use MethorZ\MarkMe\Exception\ParseException;

/**
 * BlockQuote element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuote extends AbstractElement
{
    private const string REGEX = '/^(>{1,})\s*(.*)$/';
    private const string VALID_MARKDOWN_REGEX = '/^>{1,}(\s.*)?$/m';

    /**
     * Supported features
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
     * @var array<\MethorZ\MarkMe\Element\Blockquote|\MethorZ\MarkMe\Element\Paragraph>
     */
    private array $lines = [];

    /**
     * Add a line to the blockquote
     */
    public function addLine(Paragraph|self $line): void
    {
        $this->lines[] = $line;
    }

    /**
     * Get the blockquote lines
     *
     * @return array<\MethorZ\MarkMe\Element\Blockquote|\MethorZ\MarkMe\Element\Paragraph>
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * Extract the components of the blockquote
     *
     * @return array<string, array<\MethorZ\MarkMe\Element\Blockquote|\MethorZ\MarkMe\Element\Paragraph>>
     */
    public function extractComponents(): array
    {
        return [
            'lines' => $this->lines,
        ];
    }

    /**
     * Try to create an instance of the element from a markdown string
     */
    public static function tryCreate(string $markdown): bool|self
    {
        if (empty($markdown)) {
            return false;
        }

        if (preg_match('/^>+$/', $markdown)) {
            return true;
        }

        if (!preg_match(self::VALID_MARKDOWN_REGEX, $markdown)) {
            return false;
        }

        $lines = explode(PHP_EOL, $markdown);
        $iterator = new ArrayIterator($lines);

        try {
            $rootBlockQuote = new self();
            self::parseLines($iterator, $rootBlockQuote);

            return !empty($rootBlockQuote->getLines())
                ? $rootBlockQuote
                : false;
        } catch (ParseException) { // phpcs:ignore
            return false;
        }
    }

    /**
     * Parse the lines and create the nested BlockQuote elements
     *
     * @throws \MethorZ\MarkMe\Exception\ParseException
     */
    private static function parseLines(Iterator $lines, self $rootBlockQuote): void
    {
        $blockQuoteStack = [1 => $rootBlockQuote];
        $paragraphStack = [];
        $previousLevel = 1;

        while ($lines->valid()) {
            $line = trim($lines->current(), "\r\n");

            // Skip empty lines or lines with just quote markers
            if (empty($line) || self::isEmptyQuoteLine($line)) {
                unset($paragraphStack[$previousLevel]);
                $lines->next();

                continue;
            }

            // Parse the line to extract quote level and content
            if (!preg_match(self::REGEX, $line, $matches)) {
                throw new ParseException("Invalid blockquote line: $line");
            }

            $currentLevel = strlen($matches[1]);
            $content = $matches[2];

            // Level transition handling
            if ($currentLevel !== $previousLevel) {
                // Clear paragraph context when changing levels
                unset($paragraphStack[$previousLevel]);

                // When going to a deeper level
                if ($currentLevel > $previousLevel) {
                    $newBlockQuote = new self();
                    $blockQuoteStack[$previousLevel]->addLine($newBlockQuote);
                    $blockQuoteStack[$currentLevel] = $newBlockQuote;

                // When going to a shallower level
                } else {
                    // Clear any deeper levels from stacks
                    foreach (array_keys($blockQuoteStack) as $level) {
                        if ($level > $currentLevel) {
                            unset($blockQuoteStack[$level], $paragraphStack[$level]);
                        }
                    }
                }
            }

            // Handle content
            if (!empty($content)) {
                if (!isset($paragraphStack[$currentLevel])) {
                    $paragraphStack[$currentLevel] = new Paragraph();
                    $blockQuoteStack[$currentLevel]->addLine($paragraphStack[$currentLevel]);
                }

                $paragraphStack[$currentLevel]->addLine(new Text($content));
            } else {
                unset($paragraphStack[$currentLevel]);
            }

            $previousLevel = $currentLevel;
            $lines->next();
        }
    }

    /**
     * Check if a line consists only of quote markers (potentially with whitespace)
     */
    private static function isEmptyQuoteLine(string $line): bool
    {
        return preg_match('/^>+\s*$/', $line) === 1;
    }
}
