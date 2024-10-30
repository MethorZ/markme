<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Attribute\AttributeRendererTrait;
use MethorZ\MarkMe\Element\ElementInterface;

/**
 * Default image renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ImageRenderer implements RendererInterface
{
    use AttributeRendererTrait;

    private const string ELEMENT_HTML = '<img src="{{ source }}"{{ alt }}{{ title }}{{ attributes }} />';

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $html = self::ELEMENT_HTML;

        foreach ($element->extractComponents() as $placeholder => $value) {

            if ($placeholder === 'title' && $value !== null) {
                $value = ' title="' . $value . '"';
            }

            if ($placeholder === 'alt' && $value !== null) {
                $value = ' alt="' . $value . '"';
            }

            if ($placeholder === 'attributes') {
                $value = $this->renderAttributes($value);
            }

            $html = str_replace('{{ ' . $placeholder . ' }}', is_int($value) ? (string)$value : $value ?? '', $html);
        }

        return $html;
    }
}
