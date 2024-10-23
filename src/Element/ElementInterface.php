<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Interface defining markdown element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
interface ElementInterface
{
    /**
     * Extracts the components from the element into an associative array that can be passed to the renderer
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array;
}
