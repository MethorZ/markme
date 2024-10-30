<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Attribute;

/**
 * Interface defining an attribute
 *
 * @package MethorZ\MarkMe\Attribute
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
interface AttributeInterface
{
    /**
     * Check if the attribute is an id
     */
    public function isId(): bool;

    /**
     * Check if the attribute is a class
     */
    public function isClass(): bool;

    /**
     * Check if the attribute is a style
     */
    public function isStyle(): bool;

    /**
     * Check if the attribute is a key value pair
     */
    public function isKeyValue(): bool;

    /**
     * Returns the type of the attribute
     */
    public function getType(): string;

    /**
     * Returns the value
     */
    public function getValue(): string;
}
