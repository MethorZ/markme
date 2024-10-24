<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Blockquote element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuote implements ElementInterface
{
    private const string REGEX = '/^>\s+(.*)$/';

    /**
     * Quote lines
     *
     * @var array<\MethorZ\MarkMe\Element\Blockquote|\MethorZ\MarkMe\Element\Text>
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
     */
    public static function tryCreate(string $markdown): bool|self
    {
        $result = false;

        // Parse potentially nested block quotes
        if (preg_match(self::REGEX, $markdown, $matches)) {
            $result = new self();
            $result->addLine(new Text(trim($matches[1])));
        }

        return $result;
    }
}
