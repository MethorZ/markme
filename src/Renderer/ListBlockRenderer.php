<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;

/**
 * Default list block renderer
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListBlockRenderer implements RendererInterface
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly ListItemRenderer $listItemRenderer
    ) {
    }

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $html = $element->isOrdered()
            ? '<ol>{{ items }}</ol>'
            : '<ul>{{ items }}</ul>';

        $items = '';

        foreach ($element->getItems() as $item) {
            if ($item instanceof ListItem) {
                $items .= $this->listItemRenderer->render($item);
            } elseif ($item instanceof ListBlock) {
                $items .= '<li>' . $this->render($item) . '</li>';
            }
        }

        $html = str_replace('{{ items }}', $items, $html);

        return $html;
    }
}
