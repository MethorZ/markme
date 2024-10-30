<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Attribute;

/**
 * Element attribute
 *
 * @package MethorZ\MarkMe\Attribute
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Attribute implements AttributeInterface
{
    private const string TYPE_ID = 'id';
    private const string TYPE_CLASS = 'class';
    private const string TYPE_STYLE = 'style';
    private const string TYPE_KEY_VALUE = 'key_value';

    private string $type;

    /**
     * Constructor
     */
    public function __construct(
        private string $value
    ) {
        // Check if the attribute is an id
        if (str_starts_with($value, '#')) {
            $this->type = self::TYPE_ID;
            $this->value = substr($value, 1);

        // Check if the attribute is a class
        } elseif (str_starts_with($value, '.')) {
            $this->type = self::TYPE_CLASS;
            $this->value = substr($value, 1);

        // Check for css inline styles
        } elseif (str_starts_with($value, 'style=')) {
            $this->type = self::TYPE_STYLE;

            /*
             * From inner most to outer most operations:
             * - Remove the style= part including the closing quote
             * - Remove trailing semi-colon
             * - Remove all whitespace characters
             * - Split the string by semicolon to obtain key value pairs
             * - Glue all elements back together using a semicolon and a whitespace to apply a generic formatting
             * - Append a trailing semi-colon at the end to conclude the last style setting
             */
            $this->value = implode(
                '; ',
                explode(
                    ';',
                    str_replace(
                        ' ',
                        '',
                        trim(
                            substr(
                                $value,
                                7,
                                -1
                            ),
                            ';'
                        )
                    )
                )
            ) . ';';

        // Other attributes with key and optional value
        } else {
            $this->type = self::TYPE_KEY_VALUE;
        }
    }

    /**
     * Check if the attribute is an id
     */
    public function isId(): bool
    {
        return $this->type === self::TYPE_ID;
    }

    /**
     * Check if the attribute is a class
     */
    public function isClass(): bool
    {
        return $this->type === self::TYPE_CLASS;
    }

    /**
     * Check if the attribute is a style
     */
    public function isStyle(): bool
    {
        return $this->type === self::TYPE_STYLE;
    }

    /**
     * Check if its a real attribute and not style setting
     */
    public function isKeyValue(): bool
    {
        return $this->type === self::TYPE_KEY_VALUE;
    }

    /**
     * Returns the type of the attribute
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the value
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
