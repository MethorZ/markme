<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Metadata;

use MethorZ\MarkMe\Element\AbstractElement;
use MethorZ\MarkMe\Element\ElementFeature;
use Symfony\Component\Yaml\Yaml;

/**
 * Front matter metadata
 *
 * @package MethorZ\MarkMe\Metadata
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class FrontMatter extends AbstractElement
{
    private const string REGEX = '/^---\s*\n(.*?)\n---\s*/s';
    private const string RECOGNITION_REGEX = '/^---+$/';

    /**
     * Supported element features
     *
     * @var array<string>
     */
    protected static array $features = [
        ElementFeature::SUPPORTS_MULTI_LINE,
    ];

    /**
     * Front matter data
     *
     * @var array<string,mixed>
     */
    private array $data;

    /**
     * Front matter constructor
     *
     * @param array<string,mixed> $data Front matter data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get front matter data
     *
     * @return array<string,mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Extracts the components of the element
     *
     * @return array<string,mixed>
     */
    public function extractComponents(): array
    {
        return $this->data;
    }

    /**
     * Checks if the line is a front matter line
     */
    public static function isFrontMatter(string $line): bool
    {
        return preg_match(self::RECOGNITION_REGEX, $line) === 1;
    }

    /**
     * Checks if the line matches the element and returns an instance of the element or false
     */
    public static function tryCreate(string $markdown): bool|self
    {
        $result = false;

        // Extract and remove the yaml from the content
        if (preg_match(self::REGEX, $markdown, $matches)) {
            $result = new self(Yaml::parse($matches[1]));
        }

        return $result;
    }
}
