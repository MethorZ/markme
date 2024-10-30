<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element\Custom;

use MethorZ\MarkMe\Attribute\Attribute;
use MethorZ\MarkMe\Attribute\AttributeAwareInterface;
use MethorZ\MarkMe\Attribute\AttributeAwareTrait;
use MethorZ\MarkMe\Element\AbstractElement;
use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Tag element
 *
 * @package MethorZ\MarkMe\Element\Custom
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Tag extends AbstractElement implements AttributeAwareInterface
{
    use AttributeAwareTrait;

    public const string REGEX = '/(#[a-zA-Z0-9]*[a-zA-Z][a-zA-Z0-9]*)(\{[^}]*\})?(?=\s|<br\s*\/?>|$)/';

    /**
     * Constructor
     */
    public function __construct(
        private readonly Text $tag
    ) {
    }

    /**
     * Returns the tag
     */
    public function getTag(): Text
    {
        return $this->tag;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array
    {
        return [
            'attributes' => $this->getAttributes(),
            'text' => $this->tag->getText(),
        ];
    }

    /**
     * Checks if the line matches the element and returns an instance of the element or false
     */
    public static function tryCreate(string $markdown): bool|self
    {
        $result = false;

        // Parse the comment element
        if (preg_match(self::REGEX, $markdown, $matches)) {
            // Remove the leading # inside of the matches[1]
            $matches[1] = substr($matches[1], 1);

            $result = new self(
                new Text($matches[1])
            );

            // Remove whitespaces inside the style string
            if (isset($matches[2])) {
                $matches[2] = preg_replace_callback('/style="([^"]*)"/', static function ($matches) {
                    return 'style="' . preg_replace('/\s+/', '', $matches[1]) . '"';
                }, $matches[2]);
            }

            if (!empty($matches[2])) {
                $matches[2] = trim($matches[2], '{}');

                foreach (explode(' ', $matches[2] ?? '') as $attributeString) {
                    $result->addAttribute(new Attribute($attributeString));
                }
            }
        }

        return $result;
    }
}
