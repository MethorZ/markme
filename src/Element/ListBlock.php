<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

use ArrayIterator;
use Iterator;
use MethorZ\MarkMe\Exception\ParseException;

/**
 * List block element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListBlock extends AbstractElement
{
    private const string REGEX = '/^(\s*)([-*+]|\d+\.)\s+(.*)$/';
    private const string VALID_MARKDOWN_REGEX = '/^[\s]{0,6}(?:[-+*]|\d+\.)\s.+$/m';

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
     * List items
     *
     * @var array<\MethorZ\MarkMe\Element\ListItem|\MethorZ\MarkMe\Element\ListBlock>
     */
    private array $items = [];

    /**
     * Constructor
     */
    public function __construct(
        private readonly bool $isOrdered
    ) {
    }

    /**
     * Add list item
     */
    public function addItem(ListItem|self $item): void
    {
        $this->items[] = $item;
    }

    /**
     * Returns the list items
     *
     * @return array<\MethorZ\MarkMe\Element\ListItem|\MethorZ\MarkMe\Element\ListBlock>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Returns whether the list is ordered or unordered
     */
    public function isOrdered(): bool
    {
        return $this->isOrdered;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array
    {
        return [
            'isOrdered' => $this->isOrdered,
            'items' => $this->items,
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
            return false;
        }

        $lines = explode(PHP_EOL, $markdown);

        // Count the amount of whitespace characters at the start of the line
        $indentation = strspn($lines[0], ' ');

        $rootListBlock = new self(self::isOrderedList($markdown));

        self::parseLines(new ArrayIterator($lines), $rootListBlock, $indentation);

        return $rootListBlock;
    }

    /**
     * Parse the lines and create the nested elements
     *
     * Manual Iterator handling for passing by reference across recursive loops
     *
     * @throws \MethorZ\MarkMe\Exception\ParseException
     */
    private static function parseLines(Iterator $lines, self $currentListBlock, int $indentation): void
    {
        do {
            $line = $lines->current();

            if (preg_match(self::REGEX, $line)) {
                $currentIndentation = strspn($line, ' ');

                if ($currentIndentation > $indentation) {
                    $newListBlock = new self(self::isOrderedList($line));
                    $currentListBlock->addItem($newListBlock);
                    self::parseLines($lines, $newListBlock, $currentIndentation);
                } elseif ($currentIndentation < $indentation) {
                    return;
                } else {
                    $currentListBlock->addItem(ListItem::tryCreate($line));
                    $lines->next();
                }
            } else {
                throw new ParseException('Invalid list block element during parsing');
            }
        } while ($lines->valid());
    }

    /**
     * Recognize if the line is an ordered or unordered list
     *
     * Ordered lists start numbers followed by periods. The numbers don’t have to be in numerical order, but the list should start with the number one.
     */
    private static function isOrderedList(string $markdown): bool
    {
        $lines = explode(PHP_EOL, $markdown);

        // Checking if the first line starts with number 1 followed by a period: 1.
        return preg_match('/^\s*1\./', $lines[0]) === 1;
    }
}
