<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;

/**
 * Default comment renderer
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class CommentRenderer implements RendererInterface
{
    private const string ELEMENT_HTML = '<!-- {{ comment }} -->';

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $html = self::ELEMENT_HTML;

        foreach ($element->extractComponents() as $placeholder => $value) {
            $html = str_replace('{{ ' . $placeholder . ' }}', (string)$value, $html);
        }

        return $html;
    }
}
