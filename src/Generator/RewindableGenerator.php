<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Generator;

use Generator;

/**
 * Rewindable generator
 *
 * @package MethorZ\MarkMe\Generator
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class RewindableGenerator
{
    /**
     * Elements
     *
     * @var array<int,mixed>
     */
    private array $elements = [];
    private Generator $generator;
    private int $position = -1;

    /**
     * Constructor
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Forward the generator
     */
    public function next(): mixed
    {
        $this->position++;

        if (!isset($this->elements[$this->position])) {
            if ($this->generator->valid()) {
                $this->elements[$this->position] = $this->generator->current();
                $this->generator->next();
            } else {
                return null; // End of generator
            }
        }

        return $this->elements[$this->position];
    }

    /**
     * Rewind the generator
     */
    public function prev(): mixed
    {
        if ($this->position > 0) {
            $this->position--; // phpcs:ignore

            return $this->elements[$this->position];
        }

        return null; // Start of generator
    }
}
