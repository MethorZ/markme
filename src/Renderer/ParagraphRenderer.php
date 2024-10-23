<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Text;

/**
 * Default paragraph renderer
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ParagraphRenderer implements RendererInterface
{
    private const string ELEMENT_HTML = '<p>{{ lines }}</p>';

    public function __construct(
        private readonly RendererInterface $textRenderer
    ) {
    }

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $html = self::ELEMENT_HTML;

        foreach ($element->extractComponents() as $placeholder => $value) {

            // Render the lines
            if ($placeholder === 'lines') {
                $lines = '';

                foreach ($value as $line) {
                    if ($line instanceof Text) {
                        $lines .= $this->textRenderer->render($line) . ' ';
                    }
                }

                $value = $lines;
            }

            // Remove leading and trailing spaces
            $value = trim($value);

            $html = str_replace('{{ ' . $placeholder . ' }}', (string)$value, $html);
        }

        return $html;
    }
}
