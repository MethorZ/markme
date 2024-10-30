<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Default list item renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
readonly class ListItemRenderer implements RendererInterface
{
    /**
     * Constructor
     */
    public function __construct(
        private RendererInterface $textRenderer
    ) {
    }

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $html = '<li>{{ content }}</li>';

        foreach ($element->extractComponents() as $placeholder => $value) {

            if ($value instanceof Text) {
                $value = $this->textRenderer->render($value);
            }

            $html = str_replace('{{ ' . $placeholder . ' }}', is_int($value) ? (string)$value : $value ?? '', $html);
        }

        return $html . PHP_EOL;
    }
}
