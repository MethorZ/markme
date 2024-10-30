<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

use Generator;
use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Comment;
use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\ElementFeature;
use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Element\Tracker;
use MethorZ\MarkMe\Exception\ParseException;
use MethorZ\MarkMe\Generator\RewindableGenerator;
use MethorZ\MarkMe\Metadata\FrontMatter;

/**
 * Parser for markdown
 *
 * The parser is responsible for parsing the markdown text and converting it into a list of elements
 * The order of the returned list of elements is the order in which the markdown was written.
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
     * List of parsed elements
     *
     * @var array<\MethorZ\MarkMe\Element\ElementInterface>
     */
    private array $elements = [];

    /**
     * Constructor
     */
    public function __construct(
        private readonly Tracker $tracker
    ) {
    }

    /**
     * Check whether this is the first parsing
     */
    public function isFirstParsing(): bool
    {
        return empty($this->elements);
    }

    /**
     * Parses the markdown text
     *
     * @return array<\MethorZ\MarkMe\Element\ElementInterface>
     * @throws \MethorZ\MarkMe\Exception\ParseException
     * @throws \MethorZ\MarkMe\Exception\IdentificationException
     */
    public function parse(string $markdown): array
    {
        $this->elements = [];
        $this->extractLines($markdown);

        $rewindableGenerator = new RewindableGenerator($this->getLine());

        while (($markdownLine = $rewindableGenerator->next()) !== null) {

            // Identify the current type of markdown element
            $currentElementType = Identifier::identify($markdownLine, $this->isFirstParsing());

            // Fully handle the front matter parsing and extraction
            if ($currentElementType === Identifier::FRONT_MATTER) {
                $this->parseFrontMatter($rewindableGenerator);

                // Continue to parse the next line after the front matter has been extracted
                continue;
            }

            // When currently no element is actively being parsed, start tracking the current element
            if ($this->tracker->current() === false) {
                $this->tracker->start($currentElementType);
                $this->tracker->append($markdownLine);

                // Skip to the next line for potentially multi-line elements
                continue;
            }

            // When the current element is the same as the current markdown line, append the line to the current element
            if (
                $this->tracker->current() === $currentElementType
                && $this->tracker->current()::supports(ElementFeature::SUPPORTS_MULTI_LINE)
            ) {
                $this->tracker->append($markdownLine);

                // Skip to the next line for potentially multi-line elements
                continue;
            }

            /*
             * At this point we know that the current element being looped is a different type than the element being tracked
             * This means that the currently being tracked element has ended and we can parse it, add it to the element list
             * and reset the tracker to start tracking the new element
             */
            $this->processTrackedElement();

            // Skip empty lines and dont track them
            if ($currentElementType === Identifier::EMPTY_LINE) {
                $this->tracker->reset();

                continue;
            }

            $this->tracker->start($currentElementType);
            $this->tracker->append($markdownLine);
        }

        // Process the last tracked element
        $this->processTrackedElement();
        $this->tracker->reset();

        return $this->elements;
    }

    /**
     * Normalizes the markdown text
     */
    private function extractLines(string $markdown): void
    {
        // Reset extracted lines
        $this->extractedLines = [];

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
     * Identifies current element and adds it from the tracker to the element list
     *
     * @throws \MethorZ\MarkMe\Exception\ParseException
     */
    private function processTrackedElement(): void
    {
        // Skip if the tracker is not tracking any element
        if ($this->tracker->current() === false) {
            return;
        }

        $element = match ($this->tracker->current()) {
            Identifier::FRONT_MATTER => FrontMatter::tryCreate($this->tracker->getMarkdown()),
            Identifier::HEADING => Heading::tryCreate($this->tracker->getMarkdown()),
            Identifier::BLOCKQUOTE => BlockQuote::tryCreate($this->tracker->getMarkdown()),
            Identifier::LIST_BLOCK => ListBlock::tryCreate($this->tracker->getMarkdown()),
            Identifier::HORIZONTAL_RULE => HorizontalRule::tryCreate($this->tracker->getMarkdown()),
            Identifier::COMMENT => Comment::tryCreate($this->tracker->getMarkdown()),
            Identifier::TAG => Tag::tryCreate($this->tracker->getMarkdown()),
            default => Paragraph::tryCreate($this->tracker->getMarkdown()),
        };

        if ($element === false) {
            throw new ParseException('Unable to parse the markdown line for the element type: ' . $this->tracker->current());
        }

        $this->elements[] = $element;
    }

    /**
     * Parses the front matter
     *
     * The front matter will be parsed in one go and added to the element list as it consists of multiple
     * lines of yaml data.
     *
     * Between the opening and closing front matter lines is the yaml data.
     *
     * @throws \MethorZ\MarkMe\Exception\IdentificationException
     * @throws \MethorZ\MarkMe\Exception\ParseException
     */
    private function parseFrontMatter(RewindableGenerator $rewindableGenerator): void
    {
        if ($this->tracker->current() !== false) {
            throw new ParseException('Unable to parse the front matter. There is a different element being tracked already.');
        }

        // Start tracking the front matter and add the first line
        $this->tracker->start(Identifier::identify($rewindableGenerator->current(), $this->isFirstParsing()));
        $this->tracker->append($rewindableGenerator->current());

        // Add additional lines to the front matter till the closing front matter line is reached
        while (($markdownLine = $rewindableGenerator->next()) !== null) {
            $this->tracker->append($markdownLine);

            // Stop tracking the front matter when the closing front matter line is reached
            if (Identifier::identify($markdownLine, $this->isFirstParsing()) === Identifier::FRONT_MATTER) {
                $this->processTrackedElement();
                $this->tracker->reset();

                break;
            }
        }

        // Check for successful front matter parsing and reset of the tracker
        if ($this->tracker->current() !== false || $this->isFirstParsing()) {
            throw new ParseException('Unable to parse the front matter. Check the front matter syntax. It needs to start and end with --- on separate lines.');
        }
    }
}
