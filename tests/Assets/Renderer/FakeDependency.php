<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Renderer\RendererInterface;

/**
 * Fake dependency renderer for testing
 *
 * @package MethorZ\MarkMeTest\Assets\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
readonly class FakeDependency implements RendererInterface
{
    /**
     * Fake renders an element
     */
    public function render(ElementInterface $element): string
    {
        return 'Fake dependency renderer triggered for ' . get_class($element);
    }
}
