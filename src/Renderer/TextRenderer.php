<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Renderer;

use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Image;

/**
 * Default heading renderer
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
readonly class TextRenderer implements RendererInterface
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly ImageRenderer $imageRenderer,
        #private readonly LinkRenderer $linkRenderer,
        private readonly TagRenderer $tagRenderer
    ) {
    }

    /**
     * Renders the inline markdown elements
     */
    public function render(ElementInterface $element): string
    {
        $text = $element->extractComponents()['text'];

        $text = $this->renderBoldItalic($text);
        $text = $this->renderBold($text);
        $text = $this->renderItalic($text);
        $text = $this->renderStrikethrough($text);
        $text = $this->renderCode($text);
        $text = $this->renderSubscript($text);
        $text = $this->renderSuperscript($text);
        $text = $this->renderUnderlined($text);
        $text = $this->renderImage($text);
        $text = $this->renderLink($text);
        $text = $this->renderTag($text);

        return $text;
    }

    /**
     * Parses and renders the markdown bold text
     */
    private function renderBoldItalic(string $text): string
    {
        return preg_replace('/\*\*\*(.*?)\*\*\*/', '<strong><em>$1</em></strong>', $text);
    }

    /**
     * Parses and renders the markdown bold text
     */
    private function renderBold(string $text): string
    {
        return preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
    }

    /**
     * Parses and renders the markdown italic text
     */
    private function renderItalic(string $text): string
    {
        return preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
    }

    /**
     * Parses and renders the markdown strikethrough text
     */
    private function renderStrikethrough(string $text): string
    {
        return preg_replace('/~~(.*?)~~/', '<del>$1</del>', $text);
    }

    /**
     * Parses and renders the markdown inline code
     */
    private function renderCode(string $text): string
    {
        return preg_replace('/`(.*?)`/', '<code>$1</code>', $text);
    }

    /**
     * Parses and renders the markdown subscript text
     */
    private function renderSubscript(string $text): string
    {
        return preg_replace('/~(.*?)~/', '<sub>$1</sub>', $text);
    }

    /**
     * Parses and renders the markdown superscript text
     */
    private function renderSuperscript(string $text): string
    {
        return preg_replace('/\^(.*?)\^/', '<sup>$1</sup>', $text);
    }

    /**
     * Parses and renders the markdown underlined text
     */
    private function renderUnderlined(string $text): string
    {
        return preg_replace('/__(.*?)__/', '<u>$1</u>', $text);
    }

    /**
     * Parses and renders the markdown image
     */
    private function renderImage(string $text): string
    {
        // Extract all image markdowns elements and replace them with the rendered image element
        return preg_replace_callback(Image::REGEX, function ($matches) {
            return $this->imageRenderer->render(Image::tryCreate($matches[0]));
        }, $text);
    }

    /**
     * Parses and renders the markdown link
     */
    private function renderLink(string $text): string
    {
        return preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $text);
    }

    /**
     * Parses and renders the custom markdown tag
     */
    private function renderTag(string $text): string
    {
       // Extract all tag markdowns elements and replace them with the rendered tag element
        return preg_replace_callback(Tag::REGEX, function ($matches) {
            return $this->tagRenderer->render(Tag::tryCreate($matches[0]));
        }, $text);
    }
}
