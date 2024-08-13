<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

use Generator;
use MethorZ\MarkMe\Element\Blockquote;
use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Generator\RewindableGenerator;
use Psr\Log\LoggerInterface;

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
     * Constructor
     */
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Parses the markdown text
     */
    public function parse(string $markdown): Markdown
    {
        $this->extractLines($markdown);

        $rewindableGenerator = new RewindableGenerator($this->getLine());

        $markdown = new Markdown();

        while (($markdownLine = $rewindableGenerator->next()) !== null) {

            // Parse the heading element
            if (preg_match(Heading::REGEX, $markdownLine, $matches)) {
                $heading = new Heading(
                    $this->parseInlineMarkdown(trim($matches[2])),
                    strlen($matches[1])
                );

                $markdown->addElement($heading);

                $this->logger->debug(
                    sprintf('Found heading level %d: %s', $heading->getLevel(), $heading->getText())
                );

                continue;
            }

            // Parse the blockquote element
            if (preg_match(Blockquote::REGEX, $markdownLine, $matches)) {
                $blockquote = new Blockquote(
                    $this->parseInlineMarkdown(trim($matches[1]))
                );
                $markdown->addElement($blockquote);

                $this->logger->debug(
                    sprintf('Found blockquote: %s', $blockquote->getQuote())
                );

                continue;
            }

            // Parse the list elements
            if (preg_match(ListBlock::REGEX, $markdownLine, $matches)) {

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
                        $this->parseInlineMarkdown($text)
                    );

                    // Check if we need to create a new list block or add to the existing one
                    if (empty($listStack) || $listStack[count($listStack) - 1]['indent'] < $indent) {
                        // Create a new list block
                        $listBlock = new ListBlock($isOrdered);

                        $this->logger->debug(
                            sprintf('Creating new %s list block with indent %d', $isOrdered ? 'ordered' : 'unordered', $indent)
                        );

                        $listBlock->addItem($listItem);
                        $listStack[] = ['block' => $listBlock, 'indent' => $indent];

                        $this->logger->debug(
                            sprintf('Found %s list item with indent %d: %s', $isOrdered ? 'ordered' : 'unordered', $indent, $text)
                        );
                    } else {
                        // Add the item to the existing list block
                        while (!empty($listStack) && $listStack[count($listStack) - 1]['indent'] > $indent) {
                            array_pop($listStack);
                        }

                        $listStack[count($listStack) - 1]['block']->addItem($listItem);
                    }

                    $this->logger->debug(
                        sprintf('Found %s list item with indent %d: %s', $isOrdered ? 'ordered' : 'unordered', $indent, $text)
                    );

                // While each new line is a list item
                } while (($markdownLine = $rewindableGenerator->next()) !== null && preg_match(ListBlock::REGEX, $markdownLine, $matches)); // phpcs:ignore

                // Add the list blocks to the markdown object
                foreach ($listStack as $listEntry) {
                    $markdown->addElement($listEntry['block']);
                }

                // Rewind the generator since the latest retrieved element was not a list element anymore and should be parsed again
                $rewindableGenerator->prev();

                continue;
            }

            // Parse the horizontal rule
            if (preg_match(HorizontalRule::REGEX, $markdownLine)) {
                $markdown->addElement(new HorizontalRule());

                $this->logger->debug('Found horizontal rule');

                continue;
            }

            // Add the line as a paragraph
            $markdown->addElement(new Paragraph($markdownLine));
        }

        return $markdown;
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

    /**
     * Parses the inline elements
     */
    private function parseInlineMarkdown(string $line): string
    {
        // Parse link
        $line = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $line);

        // Parse images
        $line = preg_replace('/!\[(.*?)\]\((.*?)\)/', '<img src="$2" alt="$1">', $line);

        // Parse bold text
        $line = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $line);

        // Parse italic text
        $line = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $line);

        // Parse strikethrough text
        $line = preg_replace('/~~(.*?)~~/', '<del>$1</del>', $line);

        // Parse inline code
        $line = preg_replace('/`(.*?)`/', '<code>$1</code>', $line);

        // Parse subscripts
        $line = preg_replace('/~(.*?)~/', '<sub>$1</sub>', $line);

        // Parse superscripts
        $line = preg_replace('/\^(.*?)\^/', '<sup>$1</sup>', $line);

        // Parse underlined text
        $line = preg_replace('/__(.*?)__/', '<u>$1</u>', $line);

        return $line;
    }
}
