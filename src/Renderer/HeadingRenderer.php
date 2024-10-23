<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Attribute\AttributeRendererTrait;
use MethorZ\MarkMe\Element\ElementInterface;

/**
 * Default heading renderer
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HeadingRenderer implements RendererInterface
{
    use AttributeRendererTrait;

    private const string ELEMENT_HTML = '<h{{ level }}{{ attributes }}>{{ text }}</h{{ level }}>';

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $html = self::ELEMENT_HTML;

        foreach ($element->extractComponents() as $placeholder => $value) {

            if ($placeholder === 'attributes') {
                $value = $this->renderAttributes($value);
            }

            $html = str_replace('{{ ' . $placeholder . ' }}', (string)$value, $html);
        }

        return $html;
    }
}
