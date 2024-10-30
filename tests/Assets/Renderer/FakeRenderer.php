<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets\Renderer;

use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Renderer\RendererInterface;

/**
 * Fake renderer for testing
 *
 * @package MethorZ\MarkMeTest\Assets\Renderer
 * @author Thorsten Merz <thorsten.merz@check24.de>
 * @copyright CHECK24 GmbH
 */
readonly class FakeRenderer implements RendererInterface
{
    /**
     * Constructor
     */
    public function __construct(
        private FakeDependency $dependency
    ) {
    }

    /**
     * Fake renders an element
     */
    public function render(ElementInterface $element): string
    {
        return 'Fake renderer triggered for ' . get_class($element) . ' with dependency ' . get_class($this->dependency);
    }
}
