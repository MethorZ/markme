<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

use MethorZ\MarkMe\Attribute\Attribute;
use MethorZ\MarkMe\Attribute\AttributeAwareInterface;
use MethorZ\MarkMe\Attribute\AttributeAwareTrait;

/**
 * Image element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Image implements ElementInterface, AttributeAwareInterface
{
    use AttributeAwareTrait;

    public const string REGEX = '/!\[(.*?)\]\((.*?)\s*(?:(\'|")(.*?)(\'|")\s*)?\)\s*(?:\{\s*(.*?)\s*\})?/';

    /**
     * Constructor
     */
    public function __construct(
        private readonly string $source,
        private readonly string|null $alt = null,
        private readonly string|null $title = null
    ) {
    }

    /**
     * Returns the image source
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Returns the image alt text
     */
    public function getAlt(): string|null
    {
        return $this->alt;
    }

    /**
     * Returns the image title
     */
    public function getTitle(): string|null
    {
        return $this->title;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float>
     */
    public function extractComponents(): array
    {
        return [
            'alt' => $this->alt,
            'attributes' => $this->getAttributes(),
            'source' => $this->source,
            'title' => $this->title,
        ];
    }

    /**
     * Checks if the line matches the element and returns an instance of the element or false
     */
    public static function tryCreate(string $markdown): bool|self
    {
        $result = false;

        // Parse the image element
        if (preg_match(self::REGEX, $markdown, $matches)) {
            $result = new self(
                trim($matches[2]),
                trim($matches[1]),
                isset($matches[4]) ? trim($matches[4]) : null
            );

            // Remove whitespaces inside the style string
            if (isset($matches[6])) {
                $matches[6] = preg_replace_callback('/style="([^"]*)"/', static function ($matches) {
                    return 'style="' . preg_replace('/\s+/', '', $matches[1]) . '"';
                }, $matches[6]);
            }

            if (!empty($matches[6])) {
                foreach (explode(' ', $matches[6]) as $attributeString) {
                    $result->addAttribute(new Attribute($attributeString));
                }
            }
        }

        return $result;
    }
}
