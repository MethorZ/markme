<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Enum defining element features
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
enum ElementFeature: string
{
    case SUPPORTS_NESTING = 'supportsNesting';
    case SUPPORTS_MULTI_LINE = 'supportsMultiLineContent';
}
