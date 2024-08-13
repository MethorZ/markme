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
     * Constructor
     */
    public function __construct(
        private readonly string $text,
    ) {
    }

    /**
     * Returns the heading text
     */
    public function getText(): string
    {
        return $this->text;
    }


    /**
     * Renders the markdown element as html
     */
    public function html(): string
    {
        return "<p>{$this->text}</p>";
    }
}
