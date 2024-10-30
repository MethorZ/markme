<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Element\Indentation;

/**
 * Interface defining indentation awareness
 *
 * @package MethorZ\MarkMe\Element\Indentation
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
interface IndentationAwareInterface
{
    /**
     * Increases the current indentation
     */
    public function increaseIndentation(): void;

    /**
     * Decreases the current indentation
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    public function decreaseIndentation(): void;

    /**
     * Returns the current indentation
     */
    public function getIndentation(): int;

    /**
     * Sets the indentation size
     */
    public function setIndentationSize(int $size): void;

    /**
     * Sets the indentation
     */
    public function setIndentation(int $indentation): void;

    /**
     * Returns the current indentation as string
     */
    public function indent(): string;
}
