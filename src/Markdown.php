<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

/**
 * Markdown handling
 *
 * @package MethorZ\MarkMe
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Markdown extends AbstractMarkdown
{
    /**
     * Renders the markdown to html
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     * @throws \MethorZ\MarkMe\Exception\ParseException
     * @throws \MethorZ\MarkMe\Exception\IdentificationException
     */
    public function html(string $markdown): string
    {
        $this->parsedElements = $this->parser->parse($markdown);
        $html = '';

        foreach ($this->parsedElements as $element) {
            $html .= $this->getRenderer($element::class)->render($element);
        }

        return $html;
    }
}
