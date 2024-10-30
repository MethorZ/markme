<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element\Indentation;

use MethorZ\MarkMe\Exception\RendererException;

/**
 * Trait defining indentation awareness
 *
 * @package MethorZ\MarkMe\Element\Indentation
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
trait IndentationAwareTrait
{
    private int $indentation = 0;
    private int $indentationSize = 4;

    /**
     * Increases the current indentation
     */
    public function increaseIndentation(): void
    {
        $this->indentation += $this->indentationSize;
    }

    /**
     * Decreases the current indentation
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    public function decreaseIndentation(): void
    {
        if ($this->indentation < $this->indentationSize) {
            throw new RendererException('Indentation cannot be decreased below 0');
        }

        $this->indentation -= $this->indentationSize;
    }

    /**
     * Returns the current indentation
     */
    public function getIndentation(): int
    {
        return $this->indentation;
    }

    /**
     * Sets the indentation size
     */
    public function setIndentationSize(int $size): void
    {
        $this->indentationSize = $size;
    }

    /**
     * Sets the indentation
     */
    public function setIndentation(int $indentation): void
    {
        $this->indentation = $indentation;
    }

    /**
     * Returns the current indentation as string
     */
    public function indent(): string
    {
        return str_repeat(' ', $this->indentation);
    }
}
