<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Text;

/**
 * Default block quote renderer
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
readonly class BlockQuoteRenderer implements RendererInterface
{
    /**
     * Constructor
     */
    public function __construct(
        private TextRenderer $textRenderer
    ) {
    }

    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string
    {
        $blockQuote = '<blockquote>{{ content }}</blockquote>';

        $html = '';

        foreach ($element->extractComponents()['lines'] as $line) {
            if ($line instanceof BlockQuote) {
                $html .= $this->render($line);
            } elseif ($line instanceof Text) {
                $html .= '<p>' . $this->textRenderer->render($line) . '</p>';
            } else {
                $html .= '<p>' . $line . '</p>';
            }
        }

        return str_replace('{{ content }}', $html, $blockQuote);
    }
}
