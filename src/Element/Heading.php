<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

use MethorZ\MarkMe\Attribute\Attribute;
use MethorZ\MarkMe\Attribute\AttributeAwareInterface;
use MethorZ\MarkMe\Attribute\AttributeAwareTrait;
use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Heading element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Heading extends AbstractElement implements AttributeAwareInterface
{
    use AttributeAwareTrait;

    private const string REGEX = '/^(#{1,6})\s+(.*?)(?:\s+\{\s*(.*?)\s*\})?$/';

    /**
     * Constructor
     */
    public function __construct(
        private readonly Text $text,
        private readonly int $level
    ) {
    }

    /**
     * Returns the heading text
     */
    public function getText(): Text
    {
        return $this->text;
    }

    /**
     * Returns the heading level 1-6
     */
    public function getLevel(): int
    {
        return $this->level;
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
            'level' => $this->level,
            'text' => $this->text->getText(),
        ];
    }

    /**
     * Checks if the line matches the element and returns an instance of the element or false
     */
    public static function tryCreate(string $markdown): bool|self
    {
        $result = false;

        // Parse the heading element
        if (preg_match(self::REGEX, $markdown, $matches)) {

            $result = new self(
                new Text(trim($matches[2])),
                strlen($matches[1])
            );

            // Remove whitespaces inside the style string
            if (isset($matches[3])) {
                $matches[3] = preg_replace_callback('/style="([^"]*)"/', static function ($matches) {
                    return 'style="' . preg_replace('/\s+/', '', $matches[1]) . '"';
                }, $matches[3]);

                foreach (explode(' ', $matches[3]) as $attributeString) {
                    $result->addAttribute(new Attribute($attributeString));
                }
            }
        }

        return $result;
    }
}
