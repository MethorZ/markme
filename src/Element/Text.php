<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

/**
 * Text element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
readonly class Text implements ElementInterface
{
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
     * Checks if the whole text is bold
     */
    public function isBold(): bool
    {
        // Parse bold text
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $this->text);

        return str_starts_with($text, '<strong>') && strpos($text, '</strong>') === strlen($text) - 9;
    }

    /**
     * Checks if the whole text is italic
     */
    public function isItalic(): bool
    {
        // Parse italic text
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $this->text);

        return str_starts_with($text, '<em>') && strpos($text, '</em>') === strlen($text) - 5;
    }

    /**
     * Checks if the whole text is strikethrough
     */
    public function isStrikethrough(): bool
    {
        // Parse strikethrough text
        $text = preg_replace('/~~(.*?)~~/', '<del>$1</del>', $this->text);

        return str_starts_with($text, '<del>') && strpos($text, '</del>') === strlen($text) - 6;
    }

    /**
     * Checks if the whole text is code
     */
    public function isCode(): bool
    {
        // Parse inline code
        $text = preg_replace('/`(.*?)`/', '<code>$1</code>', $this->text);

        return str_starts_with($text, '<code>') && strpos($text, '</code>') === strlen($text) - 7;
    }

    /**
     * Checks if the whole text is subscript
     */
    public function isSubscript(): bool
    {
        // Parse subscripts
        $text = preg_replace('/~(.*?)~/', '<sub>$1</sub>', $this->text);

        return str_starts_with($text, '<sub>') && strpos($text, '</sub>') === strlen($text) - 6;
    }

    /**
     * Checks if the whole text is superscript
     */
    public function isSuperscript(): bool
    {
        // Parse superscripts
        $text = preg_replace('/\^(.*?)\^/', '<sup>$1</sup>', $this->text);

        return str_starts_with($text, '<sup>') && strpos($text, '</sup>') === strlen($text) - 6;
    }

    /**
     * Checks if the whole text is underlined
     */
    public function isUnderlined(): bool
    {
        // Parse underlined text
        $text = preg_replace('/__(.*?)__/', '<u>$1</u>', $this->text);

        return str_starts_with($text, '<u>') && strpos($text, '</u>') === strlen($text) - 4;
    }

    /**
     * Checks if the whole text is an image
     */
    public function isImage(): bool
    {
        // Parse images
        $text = preg_replace('/!\[(.*?)\]\((.*?)\)/', '<img src="$2" alt="$1">', $this->text);

        return str_starts_with($text, '<img') && strpos($text, '>') === strlen($text) - 1;
    }

    /**
     * Checks if the whole text is a link
     */
    public function isLink(): bool
    {
        // Parse link
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $this->text);

        return str_starts_with($text, '<a') && strpos($text, '</a>') === strlen($text) - 4;
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
