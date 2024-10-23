<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Attribute;

/**
 * Trait defining attribute awareness
 *
 * @package MethorZ\MarkMe\Attribute
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
trait AttributeAwareTrait
{
    /**
     * Attributes
     *
     * @var array<\MethorZ\MarkMe\Attribute\AttributeInterface>
     */
    private array $attributes = [];

    /**
     * Adds an attribute to the element
     */
    public function addAttribute(AttributeInterface $attribute): void
    {
        $this->attributes[] = $attribute;
    }

    /**
     * Returns the attributes
     *
     * @return array<\MethorZ\MarkMe\Attribute\AttributeInterface>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
