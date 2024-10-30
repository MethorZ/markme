<?php

declare(strict_types = 1);

namespace MethorZ\MarkMeTest\Renderer;

use MethorZ\MarkMe\Attribute\Attribute;
use MethorZ\MarkMe\Element\Inline\Image;
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
    private $keyValueAttributeMock1; // phpcs:ignore
    private $keyValueAttributeMock2; // phpcs:ignore

    /**
     * Test for the image rendering
     */
    public function testImageRendering(): void
    {
        $element = $this->createMock(Image::class);
        $element->method('extractComponents')->willReturn([ // phpcs:ignore
            'source' => 'test.jpg',
            'alt' => 'Test',
            'title' => 'Test',
            'attributes' => [ // phpcs:ignore
                $this->keyValueAttributeMock1,
                $this->keyValueAttributeMock2,
            ],
        ]);

        $renderer = new ImageRenderer();
        $html = $renderer->render($element);

        self::assertSame('<img src="test.jpg" alt="Test" title="Test" width="100" height="200" />', $html);
    }

    /**
     * Set up
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->keyValueAttributeMock1 = $this->createMock(Attribute::class);
        $this->keyValueAttributeMock1->method('getType')->willReturn('keyValue');
        $this->keyValueAttributeMock1->method('getValue')->willReturn('width="100"');
        $this->keyValueAttributeMock1->method('isId')->willReturn(false);
        $this->keyValueAttributeMock1->method('isClass')->willReturn(false);
        $this->keyValueAttributeMock1->method('isStyle')->willReturn(false);
        $this->keyValueAttributeMock1->method('isKeyValue')->willReturn(true);

        $this->keyValueAttributeMock2 = $this->createMock(Attribute::class);
        $this->keyValueAttributeMock2->method('getType')->willReturn('keyValue');
        $this->keyValueAttributeMock2->method('getValue')->willReturn('height="200"');
        $this->keyValueAttributeMock2->method('isId')->willReturn(false);
        $this->keyValueAttributeMock2->method('isClass')->willReturn(false);
        $this->keyValueAttributeMock2->method('isStyle')->willReturn(false);
        $this->keyValueAttributeMock2->method('isKeyValue')->willReturn(true);
    }
}
