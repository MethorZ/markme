<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Assets;

use MethorZ\MarkMe\Metadata\FrontMatter;

/**
 * Tests cases / expectations / elements provider for front matter
 *
 * @package MethorZ\MarkMeTest\Assets
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class FrontMatterTestProvider
{
    /**
     * Create front matter for testing
     *
     * @return array<\MethorZ\MarkMe\Metadata\FrontMatter>
     */
    public static function getElements(): array // phpcs:ignore
    {
        /*
         * Build this markdown:
         *
         * ---
         * title: 'This is an example title'
         * description: 'This shows some basic metadata for a markdown file'
         * date: '2024-08-05'
         * author: 'MethorZ'
         * tags: ['ThisIsaTag','AnotherTag']
         * categories: ['Markdown','Front Matter']
         * ---

         */
        $frontMatter = new FrontMatter(
            [ // phpcs:ignore
                'title' => 'This is an example title',
                'description' => 'This shows some basic metadata for a markdown file',
                'date' => '2024-08-05',
                'author' => 'MethorZ',
                'tags' => ['ThisIsaTag', 'AnotherTag'],
                'categories' => ['Markdown', 'Front Matter'],
            ]
        );

        return [
            $frontMatter,
        ];
    }
}
