<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Indentation\IndentationAwareInterface;
use MethorZ\MarkMe\Element\Indentation\IndentationAwareTrait;
use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Default list item renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ListItemRenderer implements RendererInterface, IndentationAwareInterface
{
    use IndentationAwareTrait;

    /**
     * Constructor
     */
    public function __construct(
        private readonly RendererInterface $textRenderer
    ) {
    }

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $html = PHP_EOL . $this->indent() . '<li>{{ content }}';

        foreach ($element->extractComponents() as $placeholder => $value) {

            if ($value instanceof Text) {
                $value = $this->textRenderer->render($value);
            }

            $html = str_replace('{{ ' . $placeholder . ' }}', is_int($value) ? (string)$value : $value ?? '', $html);
        }

        return $html . '</li>';
    }
}
