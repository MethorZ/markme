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
class Blockquote implements ElementInterface
{
    public const string REGEX = '/^>\s+(.*)$/';

    /**
     * Constructor
     */
    public function __construct(
        private readonly string $quote
    ) {
    }

    /**
     * Returns the heading text
     */
    public function getQuote(): string
    {
        return $this->quote;
    }

    /**
     * Renders the markdown element as html
     */
    public function html(): string
    {
        return '<blockquote>' . $this->quote . '</blockquote>';
    }
}
