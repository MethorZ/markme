<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;

/**
 * Default list block renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
readonly class ListBlockRenderer implements RendererInterface
{
    /**
     * Constructor
     */
    public function __construct(
        private RendererInterface $listItemRenderer
    ) {
    }

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $html = $element->isOrdered()
            ? "<ol>{{ items }}\n</ol>"
            : "<ul>{{ items }}\n</ul>";

        $items = '';

        foreach ($element->getItems() as $item) {
            if ($item instanceof ListItem) {
                $items .= PHP_EOL . $this->listItemRenderer->render($item);
            } elseif ($item instanceof ListBlock) {
                $items .= PHP_EOL . '<li>' . PHP_EOL . $this->render($item) . PHP_EOL . '</li>';
            }
        }

        return str_replace('{{ items }}', $items, $html) . PHP_EOL;
    }
}
