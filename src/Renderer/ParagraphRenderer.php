<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Indentation\IndentationAwareInterface;
use MethorZ\MarkMe\Element\Indentation\IndentationAwareTrait;
use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Default paragraph renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ParagraphRenderer implements RendererInterface, IndentationAwareInterface
{
    use IndentationAwareTrait;

    private const string ELEMENT_HTML = '<p>{{ lines }}</p>';

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
        $html = self::ELEMENT_HTML;

        foreach ($element->extractComponents() as $placeholder => $value) {

            // Render the lines
            if ($placeholder === 'lines') {
                $lines = '';

                $this->increaseIndentation();

                foreach ($value as $line) {
                    if ($line instanceof Text) {
                        $lines .= empty($lines)
                            ? $this->textRenderer->render($line)
                            : PHP_EOL . $this->indent() . $this->textRenderer->render($line);
                    }
                }

                $this->decreaseIndentation();

                $value = $lines;
            }

            // Remove leading and trailing spaces
            $value = trim($value);

            $html = str_replace('{{ ' . $placeholder . ' }}', (string)$value, $html);
        }

        return $html . PHP_EOL;
    }
}
