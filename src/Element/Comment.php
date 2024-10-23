<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * HTML comment element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Comment implements ElementInterface
{
    private const string REGEX = '/<!--\s*(.*?)\s*-->/';

    /**
     * Constructor
     */
    public function __construct(
        private readonly string $comment
    ) {
    }

    /**
     * Returns the heading text
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array
    {
        return [
            'comment' => $this->comment,
        ];
    }

    /**
     * Checks if the line matches the element and returns an instance of the element or false
     */
    public static function tryCreate(string $markdown): bool|self
    {
        $result = false;

        // Parse the comment element
        if (preg_match(self::REGEX, $markdown, $matches)) {
            $result = new self(
                trim($matches[1])
            );
        }

        return $result;
    }
}
