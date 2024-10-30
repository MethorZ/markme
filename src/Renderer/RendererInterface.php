<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;

/**
 * Interface defining a renderer for an element
 *
 * @package MethorZ\MarkMe\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
interface RendererInterface
{
    /**
     * Renders the markdown element
     */
    public function render(ElementInterface $element): string;
}
