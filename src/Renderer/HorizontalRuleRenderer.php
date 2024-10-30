<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;

/**
 * Default horizontal rule renderer
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HorizontalRuleRenderer implements RendererInterface
{
    /**
     * Renders the element
     */
    public function render(ElementInterface $element): string // phpcs:ignore
    {
        return '<hr />' . PHP_EOL;
    }
}
