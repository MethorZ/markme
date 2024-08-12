<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Heading element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Heading implements ElementInterface
{
    public const string REGEX = '/^(#{1,6})\s+(.*)$/';

    /**
     * Constructor
     */
    public function __construct(
        private readonly string $text,
        private readonly int $level
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
     * Returns the heading level 1-6
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * Renders the markdown element as html
     */
    public function html(): string
    {
        return "<h{$this->level}>{$this->text}</h{$this->level}>";
    }
}
