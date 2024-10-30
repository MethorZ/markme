<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Abstract markdown element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
abstract class AbstractElement implements ElementInterface
{
    /**
     * List of supported features by the element
     *
     * @var array<string>
     */
    protected static array $features = [];

    /**
     * Extracts the components from the element into an associative array that can be passed to the renderer
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    abstract public function extractComponents(): array;

    /**
     * Check if the element supports a specific feature
     */
    public static function supports(ElementFeature $feature): bool
    {
        return in_array($feature, static::$features, true);
    }

    /**
     * Returns the list of supported features
     *
     * @return array<string>
     */
    public static function getSupportedFeatures(): array
    {
        return static::$features;
    }
}
