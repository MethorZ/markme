<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

use Generator;
use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Comment;
use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Generator\RewindableGenerator;

/**
 * Parser for markdown
 *
 * @package MethorZ\MarkMe
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Parser
{
    /**
     * Extracted lines before actual parsing
     *
     * @var array<string>
     */
    private array $extractedLines = [];

    /**
     * Parses the markdown text
     *
     * @return array<\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function parse(string $markdown): array
    {
        $this->extractLines($markdown);

        $rewindableGenerator = new RewindableGenerator($this->getLine());

        $elements = [];

        while (($markdownLine = $rewindableGenerator->next()) !== null) {

            // Parse the heading element
            $element = Heading::tryCreate($markdownLine);

            if ($element !== false) {
                $elements[] = $element;

                continue;
            }

            // Parse the blockquote element while the next line is also a blockquote element
            $element = BlockQuote::tryCreate($markdownLine);

            if ($element !== false) {

                while (
                    ($markdownLine = $rewindableGenerator->next()) !== null
                    && ($nextElement = BlockQuote::tryCreate($markdownLine)) !== false
                ) {
                    foreach ($nextElement->getLines() as $line) {
                        $element->addLine(
                            is_string($line) ? new Text($line) : $line
                        );
                    }
                }

                $elements[] = $element;

                // Rewind the generator since the latest retrieved element was not a blockquote element anymore and should be parsed again
                $rewindableGenerator->prev();

                continue;
            }

            // Parse the list elements
            if (preg_match(ListItem::REGEX, $markdownLine, $matches)) {

                // Initialize a stack to keep track of list blocks and their indentation levels
                $listStack = [];

                do {
                    $indent = strlen($matches[1]);
                    $marker = $matches[2];
                    $text = trim($matches[3]);

                    // Determine if the list is ordered or unordered
                    $isOrdered = is_numeric(rtrim($marker, '.'));

                    // Create a new list item
                    $listItem = new ListItem(
                        new Text($text)
                    );

                    // Check if we need to create a new list block or add to the existing one
                    if (empty($listStack) || $listStack[count($listStack) - 1]['indent'] < $indent) {
                        // Create a new list block
                        $listBlock = new ListBlock($isOrdered, $indent);

                        $listBlock->addItem($listItem);
                        $listStack[] = ['block' => $listBlock, 'indent' => $indent];
                    } else {
                        // Add the item to the existing list block
                        while (!empty($listStack) && $listStack[count($listStack) - 1]['indent'] > $indent) {
                            array_pop($listStack);
                        }

                        $listStack[count($listStack) - 1]['block']->addItem($listItem);
                    }

                // While each new line is a list item
                } while (($markdownLine = $rewindableGenerator->next()) !== null && preg_match(ListItem::REGEX, $markdownLine, $matches)); // phpcs:ignore

                // Add the list blocks to the markdown object
                foreach ($listStack as $listEntry) {
                    $elements[] = $listEntry['block'];
                }

                // Rewind the generator since the latest retrieved element was not a list element anymore and should be parsed again
                $rewindableGenerator->prev();

                continue;
            }

            // Parse the horizontal rule
            $element = HorizontalRule::tryCreate($markdownLine);

            if ($element !== false) {
                $elements[] = $element;

                continue;
            }

            // Parse html comments
            $element = Comment::tryCreate($markdownLine);

            if ($element !== false) {
                $elements[] = $element;

                continue;
            }

            if (!empty($markdownLine)) {
                // Create a new paragraph element
                $paragraph = new Paragraph();

                do {
                    // Keep adding lines to the paragraph element until an empty line is found
                    $paragraph->addLine(new Text($markdownLine));
                } while (($markdownLine = $rewindableGenerator->next()) !== null && !empty($markdownLine));

                // Parse the paragraph element while not getting an empty line
                $elements[] = $paragraph;
            }
        }

        return $elements;
    }

    /**
     * Normalizes the markdown text
     */
    private function extractLines(string $markdown): void
    {
        // Normalize line breaks
        $markdown = str_replace(["\r\n", "\r"], "\n", $markdown);

        // Remove line breaks around the text
        $markdown = trim($markdown, "\n");

        // Split the whole text into lines
        $this->extractedLines = explode("\n", $markdown);
    }

    /**
     * Returns an iterator for the lines
     */
    private function getLine(): Generator
    {
        // Yield each line
        foreach ($this->extractedLines as $line) {
            yield $line;
        }
    }
}
