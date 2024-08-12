<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Code block element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class CodeBlock implements ElementInterface
{
    public const string REGEX = '';

    /**
     * Constructor
     */
    public function __construct(
        private readonly string $text
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
        return '<code>' . $this->text . '</code>';
    }
}
