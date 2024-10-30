<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Metadata;

use MethorZ\MarkMe\Metadata\FrontMatter;
use MethorZ\MarkMeTest\Assets\FrontMatterTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the front matter metadata
 *
 * @package MethorZ\MarkMeTest\Metadata
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class FrontMatterTest extends TestCase
{
    /**
     * Test the tryCreate method
     */
    public function testCreateFrontMatter(): void
    {
        $expectations = FrontMatterTestProvider::getElements();
        $markdown = file_get_contents(__DIR__ . '/../Assets/front-matter.md');
        $frontMatter = FrontMatter::tryCreate($markdown);

        self::assertEquals($expectations[0], $frontMatter);
    }

    /**
     * Test the tryCreate method with a missing front matter
     */
    public function testCreateFrontMatterWithoutFrontMatter(): void
    {
        $markdown = "This a string without any front matter\ntest: value";
        $frontMatter = FrontMatter::tryCreate($markdown);

        self::assertFalse($frontMatter);
    }
}
