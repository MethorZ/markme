<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Indentation\IndentationAwareInterface;
use MethorZ\MarkMe\Element\Indentation\IndentationAwareTrait;
use MethorZ\MarkMe\Element\Paragraph;

/**
 * Default block quote renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class BlockQuoteRenderer implements RendererInterface, IndentationAwareInterface
{
    use IndentationAwareTrait;

    /**
     * Constructor
     */
    public function __construct(
        private readonly ParagraphRenderer $paragraphRenderer
    ) {
    }

    /**
     * Renders the element
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    public function render(ElementInterface $element): string
    {
        $html = $this->indent() . '<blockquote>' . PHP_EOL;

        $this->increaseIndentation();

        foreach ($element->extractComponents()['lines'] as $line) {
            if ($line instanceof BlockQuote) {
                $html .= $this->render($line);
            } elseif ($line instanceof Paragraph) {
                $this->paragraphRenderer->setIndentation($this->getIndentation());
                $html .= $this->indent() . $this->paragraphRenderer->render($line);
            }
        }

        $this->decreaseIndentation();

        $html .= $this->indent() . '</blockquote>';

        return $html . PHP_EOL;
    }
}
