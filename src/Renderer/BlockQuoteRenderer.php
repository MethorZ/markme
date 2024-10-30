<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Default block quote renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuoteRenderer implements RendererInterface
{
    private int $indentation = 0;
    private int $indentationStep = 4;

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
        $blockQuote = '{{ identation }}<blockquote>{{ content }}' . PHP_EOL . '{{ identation }}</blockquote>';

        $html = '';

        foreach ($element->extractComponents()['lines'] as $line) {
            $this->increaseIndentation();

            if ($line instanceof BlockQuote) {
                $html .= PHP_EOL . PHP_EOL . $this->render($line);
            } elseif ($line instanceof Text) {
                $html .= PHP_EOL . $this->addIndentation() . '<p>' . $this->textRenderer->render($line) . '</p>';
            } else {
                $html .= PHP_EOL . $this->addIndentation() . '<p>' . $line . '</p>';
            }

            $this->decreaseIndentation();
        }

        $html = str_replace('{{ content }}', $html, $blockQuote);

        return str_replace('{{ identation }}', $this->addIndentation(), $html);
    }

    /**
     * Retrieves the indentation
     */
    protected function addIndentation(int $start = 0): string
    {
        return str_repeat(' ', $start + $this->indentation);
    }

    /**
     * Increases the indentation
     */
    protected function increaseIndentation(): void
    {
        $this->indentation += $this->indentationStep;
    }

    /**
     * Decreases the indentation
     */
    protected function decreaseIndentation(): void
    {
        $this->indentation -= $this->indentationStep;
    }
}
