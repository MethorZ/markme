<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element\Inline;

use MethorZ\MarkMe\Element\AbstractElement;
use MethorZ\MarkMe\Element\ElementFeature;

/**
 * Text element
 *
 * @package MethorZ\MarkMe\Element\Inline
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Text extends AbstractElement
{
    /**
     * Supported element features
     *
     * @var array<string>
     */
    protected static array $features = [
        ElementFeature::SUPPORTS_MULTI_LINE,
    ];

    /**
     * Constructor
     */
    public function __construct(
        private readonly string $text
    ) {
    }

    /**
     * Returns the text
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Checks if the text contains bold markdown
     *
     * This checks if the text is surrounded by two asterisks
     */
    public function containsBoldMarkdown(): bool
    {
        return preg_match('/\*\*[^*]+\*\*(?!\*)/', $this->text) === 1;
    }

    /**
     * Checks if the text contains italic markdown
     */
    public function containsItalicMarkdown(): bool
    {
        return preg_match('/(?<!\*)\*[^*]+\*(?!\*)/', $this->text) === 1;
    }

    /**
     * Checks if the text contains strikethrough markdown
     */
    public function containsStrikethroughMarkdown(): bool
    {
        return preg_match('/(?<!~)~~[^~]+~~(?!~)/', $this->text) === 1;
    }

    /**
     * Checks if the text contains code markdown
     */
    public function containsCodeMarkdown(): bool
    {
        return preg_match('/(?<!`)`[^`]+`(?!`)/', $this->text) === 1;
    }

    /**
     * Checks if the text contains subscript markdown
     */
    public function containsSubscriptMarkdown(): bool
    {
        return preg_match('/(?<!~)~[^~]+~(?!~)/', $this->text) === 1;
    }

    /**
     * Checks if the text contains superscript markdown
     */
    public function containsSuperscriptMarkdown(): bool
    {
        return preg_match('/(?<!\^)\^[^^]+\^(?!\^)/', $this->text) === 1;
    }

    /**
     * Checks if the text contains underlined markdown
     */
    public function containsUnderlinedMarkdown(): bool
    {
        return preg_match('/(?<!_)__[^_]+__(?!_)/', $this->text) === 1;
    }

    /**
     * Checks if the text contains an image
     */
    public function containsImage(): bool
    {
        return preg_match('/!\[.*\]\(.*\)/', $this->text) === 1;
    }

    /**
     * Checks if the text contains a link
     */
    public function containsLink(): bool
    {
        return preg_match('/\[.*\]\(.*\)/', $this->text) === 1;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float>
     */
    public function extractComponents(): array
    {
        return [
            'text' => $this->text,
        ];
    }

    /**
     * Returns the text as string
     */
    public function __toString(): string
    {
        return $this->text;
    }
}
