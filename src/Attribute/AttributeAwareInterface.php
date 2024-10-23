<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Attribute;

/**
 * Interface defining attribute awareness
 *
 * @package MethorZ\MarkMe\Attribute
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
interface AttributeAwareInterface
{
    /**
     * Adds an attribute to the element
     */
    public function addAttribute(AttributeInterface $attribute): void;

    /**
     * Returns the attributes
     *
     * @return array<\MethorZ\MarkMe\Attribute\AttributeInterface>
     */
    public function getAttributes(): array;
}
