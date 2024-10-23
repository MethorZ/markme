<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Horizontal rule element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HorizontalRule implements ElementInterface
{
    private const string REGEX = '/^---$/';

    /**
     * Checks if the line matches the element and returns an instance of the element or false
     */
    public static function tryCreate(string $markdown): bool|self
    {
        return preg_match(self::REGEX, $markdown)
            ? new self()
            : false;
    }

    /**
     * Extracts the components of the element
     */
    public function extractComponents(): array
    {
        return [];
    }
}
