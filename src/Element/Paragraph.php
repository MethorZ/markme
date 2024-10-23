<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Paragraph element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Paragraph implements ElementInterface
{
    public const string REGEX = '/^\s*$/';

    /**
     * List of lines inside the paragraph
     *
     * @var array<\MethorZ\MarkMe\Element\Text>
     */
    private array $lines = [];

    /**
     * Returns the paragraph text
     *
     * @return array<\MethorZ\MarkMe\Element\Text>
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * Adds a line to the paragraph
     */
    public function addLine(Text $line): void
    {
        $this->lines[] = $line;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array
    {
        return [
            'lines' => $this->getLines(),
        ];
    }
}
