<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Status tracker for element parser
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Tracker
{
    private string $currentElement;
    private string $markdown;

    /**
     * Starts tracking a new element
     */
    public function start(string $element): void
    {
        $this->reset();
        $this->currentElement = $element;
    }

    /**
     * Resets the tracker
     */
    public function reset(): void
    {
        unset($this->currentElement);
        unset($this->markdown);
    }

    /**
     * Returns the currently tracked element
     *
     * @return class-string<\MethorZ\MarkMe\Element\AbstractElement>|false
     */
    public function current(): string|false
    {
        return $this->currentElement ?? false;
    }

    /**
     * Appends markdown lines to be gathered for current element
     */
    public function append(string $line): void
    {
        if (!isset($this->markdown)) {
            $this->markdown = $line;
        } else {
            $this->markdown .= "\n" . $line;
        }
    }

    /**
     * Returns the current markdown
     */
    public function getMarkdown(): string|null
    {
        return $this->markdown ?? null;
    }
}
