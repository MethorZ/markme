<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element;

use MethorZ\MarkMe\Element\Inline\Text;

/**
 * Paragraph element
 *
 * @package MethorZ\MarkMe\Element
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Paragraph extends AbstractElement
{
    #public const string REGEX = '/^\s*$/';
    public const string REGEX = '/^.+$/ms';

    /**
     * Supported element features
     *
     * @var array<string>
     */
    protected static array $features = [
        ElementFeature::SUPPORTS_MULTI_LINE,
    ];

    /**
     * List of lines inside the paragraph
     *
     * @var array<\MethorZ\MarkMe\Element\Inline\Text>
     */
    private array $lines = [];

    /**
     * Returns the paragraph text
     *
     * @return array<\MethorZ\MarkMe\Element\Inline\Text>
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * Adds a line to the paragraph
     */
    public function addLine(Text $line): void
    {
        $this->lines[] = $line;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,string|int|bool|float|\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function extractComponents(): array
    {
        return [
            'lines' => $this->getLines(),
        ];
    }

    /**
     * Checks if the line matches the element and returns an instance of the element or false
     */
    public static function tryCreate(string $markdown): bool|self
    {
        $result = false;

        // Parse the comment element
        if (preg_match(self::REGEX, $markdown)) {
            $result = new self();

            // Split the markdown into lines after converting html breaks to new lines
            $lines = explode("\n", $markdown);

            foreach ($lines as $line) {
                $result->addLine(new Text($line));
            }
        }

        return $result;
    }
}
