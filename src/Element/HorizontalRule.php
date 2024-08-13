<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Horizontal rule element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class HorizontalRule implements ElementInterface
{
    public const string REGEX = '/^---$/';

    /**
     * Renders the markdown element as html
     */
    public function html(): string
    {
        return '<hr>';
    }
}
