<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Unordered element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListBlock implements ElementInterface
{
    public const REGEX = '/^(\s*)([*+-]|\d+\.)\s+((?:\[(.*?)\]\((.*?)\)|!\[(.*?)\]\((.*?)\)|.*?)+)$/';

    /**
     * List items
     *
     * @var array<\MethorZ\MarkMe\Element\ListItem|\MethorZ\MarkMe\Element\ListBlock>
     */
    private array $items = [];

    /**
     * Constructor
     */
    public function __construct(
        private readonly bool $isOrdered
    ) {
    }

    /**
     * Add list item
     */
    public function addItem(ListItem|ListBlock $item): void
    {
        $this->items[] = $item;
    }

    /**
     * Returns the heading text
     */
    public function getItems(): string
    {
        return $this->items;
    }

    /**
     * Returns the indentation
     */
    public function getIndentation(): int
    {
        return $this->indentation;
    }

    /**
     * Returns whether the list is ordered or unordered
     */
    public function isOrdered(): bool
    {
        return $this->isOrdered;
    }

    /**
     * Renders the markdown element as html
     */
    public function html(): string
    {
        $html = $this->isOrdered ? '<ol>' : '<ul>';

        foreach ($this->items as $item) {
            $html .= $item->html();
        }

        $html .= $this->isOrdered ? '</ol>' : '</ul>';

        return $html;
    }
}
