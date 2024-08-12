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
     * Renders the markdown element as html
     */
    public function html(): string;
}
