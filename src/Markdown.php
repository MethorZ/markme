<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

use MethorZ\MarkMe\Metadata\FrontMatter;

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
     * Returns the front matter if it exists
     */
    public function frontMatter(): FrontMatter|false
    {
        foreach ($this->parsedElements as $element) {
            if ($element instanceof FrontMatter) {
                return $element;
            }
        }

        return false;
    }

    /**
     * Renders the markdown to html
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    public function html(): string
    {
        $html = '';

        foreach ($this->parsedElements as $element) {

            // Front matter is not rendered
            if ($element instanceof FrontMatter) {
                continue;
            }

            $html .= $this->getRenderer($element::class)->render($element);
        }

        return $html;
    }
}
