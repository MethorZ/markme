<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

use MethorZ\MarkMe\Element\ElementInterface;

/**
 * Markdown
 *
 * @package MethorZ\FileSystem
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Markdown
{
    /**
     * Markdown elements
     *
     * @var array<\MethorZ\MarkMe\Element\ElementInterface>
     */
    private array $elements = [];

    /**
     * Add the element to the markdown element list
     */
    public function addElement(ElementInterface $element): void
    {
        $this->elements[] = $element;
    }

    /**
     * Returns the elements
     *
     * @return array<\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * Renders the markdown as html
     */
    public function html(): string
    {
        $html = '';

        foreach ($this->elements as $element) {
            $html .= $element->html();
        }

        return $html;
    }
}
