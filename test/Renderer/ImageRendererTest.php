<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Element\Image;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the image renderer
 *
 * @package MethorZ\MarkMeTest\Renderer
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class ImageRendererTest extends TestCase
{
    /**
     * Test for the image rendering
     */
    public function testImageRendering(): void
    {
        $image = new Image('image.jpg', 'An image');
        $renderer = new ImageRenderer();
        $html = $renderer->render($image);

        self::assertEquals('<img src="image.jpg" alt="An image" />', $html);
    }
}
