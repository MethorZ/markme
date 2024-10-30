<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

use MethorZ\MarkMe\Element\Inline\Text;

/**
 * List Item element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListItem extends AbstractElement
{
    public const string REGEX = '/^(\s*)([*+-]|\d+\.)\s+((?:\[(.*?)\]\((.*?)\)|!\[(.*?)\]\((.*?)\)|.*?)+)$/';

    /**
     * Constructor
     */
    public function __construct(
        private readonly Text $content
    ) {
    }

    /**
     * Returns the heading text
     */
    public function getContent(): Text
    {
        return $this->content;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array
    {
        return [
            'content' => $this->content,
        ];
    }

    /**
     * Parses the markdown and returns the element if it matches
     */
    public static function tryCreate(string $markdown): bool|self
    {
        $result = false;

        // Parse the list item element
        if (preg_match(self::REGEX, $markdown, $matches)) {
            $content = new Text(trim($matches[3]));

            $result = new self(
                $content
            );
        }

        return $result;
    }
}
