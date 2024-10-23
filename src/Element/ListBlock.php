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
        private readonly bool $isOrdered,
        private readonly int $indentation
    ) {
    }

    /**
     * Add list item
     */
    public function addItem(ListItem|self $item): void
    {
        $this->items[] = $item;
    }

    /**
     * Returns the list items
     *
     * @return array<\MethorZ\MarkMe\Element\ListItem|\MethorZ\MarkMe\Element\ListBlock>
     */
    public function getItems(): array
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
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array
    {
        return [
            'indentation' => $this->indentation,
            'isOrdered' => $this->isOrdered,
            'items' => $this->items,
        ];
    }
}
