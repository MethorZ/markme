<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Indentation\IndentationAwareInterface;
use MethorZ\MarkMe\Element\Indentation\IndentationAwareTrait;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;

/**
 * Default list block renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListBlockRenderer implements RendererInterface, IndentationAwareInterface
{
    use IndentationAwareTrait;

    /**
     * Constructor
     */
    public function __construct(
        private readonly ListItemRenderer $listItemRenderer
    ) {
    }

    /**
     * Renders the element
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    public function render(ElementInterface $element): string
    {
        $html = $element->isOrdered()
            ? $this->indent() . '<ol>'
            : $this->indent() . '<ul>';

        // Indent list elements by one level
        $this->increaseIndentation();

        foreach ($element->getItems() as $item) {

            if ($item instanceof ListItem) {
                $this->listItemRenderer->setIndentation($this->getIndentation());
                $html .= $this->listItemRenderer->render($item);
            } elseif ($item instanceof ListBlock) {
                $html .= PHP_EOL . $this->indent() . '<li>' . PHP_EOL;
                $this->increaseIndentation();
                $html .= $this->render($item);
                $this->decreaseIndentation();
                $html .= $this->indent() . '</li>';
            }
        }

        // After children have been rendered, decrease indentation again
        $this->decreaseIndentation();

        $html .= $element->isOrdered()
            ? PHP_EOL . $this->indent() . '</ol>'
            : PHP_EOL . $this->indent() . '</ul>';

        return $html . PHP_EOL;
    }
}
