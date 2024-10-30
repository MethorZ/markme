<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Comment;
use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Exception\IdentificationException;
use MethorZ\MarkMe\Metadata\FrontMatter;

/**
 * Markdown element identifier
 *
 * @package MethorZ\MarkMe
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Identifier
{
    /**
     * Identifier for the blockquote element
     */
    public const string BLOCKQUOTE = BlockQuote::class;

    /**
     * Identifier for the front matter metadata
     */
    public const string FRONT_MATTER = FrontMatter::class;

    /**
     * Identifier for the comment element
     */
    public const string COMMENT = Comment::class;

    /**
     * Identifier for the heading element
     */
    public const string HEADING = Heading::class;

    /**
     * Identifier for the horizontal rule element
     */
    public const string HORIZONTAL_RULE = HorizontalRule::class;

    /**
     * Identifier for the list block element
     */
    public const string LIST_BLOCK = ListBlock::class;

    /**
     * Identifier for the list item element
     */
    public const string LIST_ITEM = ListItem::class;

    /**
     * Identifier for the paragraph element
     */
    public const string PARAGRAPH = Paragraph::class;

    /**
     * Identifier for the tag element
     */
    public const string TAG = Tag::class;

    /**
     * Identifier for an new (empty) line
     */
    public const string NEW_LINE = NewLine::class;

    /**
     * Identify the markdown element
     *
     * @throws \MethorZ\MarkMe\Exception\IdentificationException
     * @throws \MethorZ\MarkMe\Exception\ParseException
     */
    public static function identify(string $markdownLine, bool $isFirstParsing = false): string
    {
        if (NewLine::tryCreate($markdownLine) !== false) {
            return self::NEW_LINE;
        }

        if (BlockQuote::tryCreate($markdownLine) !== false) {
            return self::BLOCKQUOTE;
        }

        if (Comment::tryCreate($markdownLine) !== false) {
            return self::COMMENT;
        }

        if (Heading::tryCreate($markdownLine) !== false) {
            return self::HEADING;
        }

        // Differentiate between horizontal rule and front matter
        if (HorizontalRule::tryCreate($markdownLine) !== false) {
            // If this is the very first parsing, we assume that the horizontal rule is a front matter
            if ($isFirstParsing && FrontMatter::isFrontMatter($markdownLine)) {
                return self::FRONT_MATTER;
            }

            return self::HORIZONTAL_RULE;
        }

        if (ListBlock::tryCreate($markdownLine) !== false) {
            return self::LIST_BLOCK;
        }

        if (ListItem::tryCreate($markdownLine) !== false) {
            return self::LIST_ITEM;
        }

        if (Tag::tryCreate($markdownLine) !== false) {
            return self::TAG;
        }

        if (Paragraph::tryCreate($markdownLine)) {
            return self::PARAGRAPH;
        }

        throw new IdentificationException('Unable to identify the markdown element  for: ' . $markdownLine);
    }
}
