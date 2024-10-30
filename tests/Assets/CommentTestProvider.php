<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Element\Comment;

/**
 * Tests cases / expectations / elements provider for comments
 *
 * @package MethorZ\MarkMeTest\Assets
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class CommentTestProvider
{
    /**
     * Create comments for testing
     *
     * @return array<\MethorZ\MarkMe\Element\Comment>
     */
    public static function getElements(): array // phpcs:ignore
    {
        /*
         * Build this markdown:
         *
         * <!-- This is a comment -->
         *
         * The following comments are not yet supported!
         *
         * <!-- This is a multiline comment
         *     that spans multiple lines
         *     and describes the following code block -->
         *
         * <!-- This is a multiline comment
         *     that spans multiple lines
         *     and describes the following code block
         * -->
         *
         * <!--
         *     This is a multiline comment
         *     that spans multiple lines
         *     and describes the following code block
         * -->
         */
        $comment1 = new Comment('This is a comment');

        return [
            $comment1,
        ];
    }
}
