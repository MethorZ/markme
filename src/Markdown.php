<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Comment;
use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\ElementInterface;
use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Element\Image;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Element\Text;
use MethorZ\MarkMe\Exception\RendererException;
use MethorZ\MarkMe\Renderer\BlockQuoteRenderer;
use MethorZ\MarkMe\Renderer\CommentRenderer;
use MethorZ\MarkMe\Renderer\HeadingRenderer;
use MethorZ\MarkMe\Renderer\HorizontalRuleRenderer;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\ListBlockRenderer;
use MethorZ\MarkMe\Renderer\ListItemRenderer;
use MethorZ\MarkMe\Renderer\ParagraphRenderer;
use MethorZ\MarkMe\Renderer\RendererInterface;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;

/**
 * Markdown
 *
 * @package MethorZ\FileSystem
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
class Markdown
{
    /**
     * Markdown elements
     *
     * @var array<\MethorZ\MarkMe\Element\ElementInterface>
     */
    private array $elements = [];

    /**
     * Map of element renderers
     *
     * @var array<string,\MethorZ\MarkMe\Renderer\RendererInterface>
     */
    private array $elementRendererMap = [
        BlockQuote::class => BlockQuoteRenderer::class,
        Comment::class => CommentRenderer::class,
        Heading::class => HeadingRenderer::class,
        HorizontalRule::class => HorizontalRuleRenderer::class,
        Image::class => ImageRenderer::class,
        ListBlock::class => ListBlockRenderer::class,
        ListItem::class => ListItemRenderer::class,
        Paragraph::class => ParagraphRenderer::class,
        Tag::class => TagRenderer::class,
        Text::class => TextRenderer::class,
    ];

    /**
     * List of dependencies for each renderer
     *
     * @var array<string,array<string>>
     */
    private array $rendererDependencyMap = [
        BlockQuoteRenderer::class => [TextRenderer::class],
        ListBlockRenderer::class => [ListItemRenderer::class],
        ListItemRenderer::class => [TextRenderer::class],
        ParagraphRenderer::class => [TextRenderer::class],
        TextRenderer::class => [ImageRenderer::class, TagRenderer::class],
    ];

    /**
     * Constructor
     */
    public function __construct(
        private readonly Parser $parser
    ) {
    }

    /**
     * Add the element to the markdown element list
     */
    public function addElement(ElementInterface $element): void
    {
        $this->elements[] = $element;
    }

    /**
     * Returns the elements
     *
     * @return array<\MethorZ\MarkMe\Element\ElementInterface>
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * Parses the markdown text
     */
    public function parse(string $markdown): void
    {
        $this->elements = $this->parser->parse($markdown);
    }

    /**
     * Renders the markdown as html
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    public function render(): string
    {
        $html = '';

        foreach ($this->elements as $element) {
            $html .= $this->getRenderer($element::class)->render($element);
        }

        return $html;
    }

    /**
     * Overrides the default element renderer
     *
     * @param array<string> $dependencies
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    public function setRenderer(string $elementClass, string $rendererClass, array $dependencies = []): void
    {
        if (!class_exists($rendererClass)) {
            throw new RendererException('Renderer class ' . $rendererClass . ' not found');
        }

        $this->elementRendererMap[$elementClass] = $rendererClass;
        $this->rendererDependencyMap[$rendererClass] = $dependencies;
    }

    /**
     * Returns the renderer for the element
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    protected function getRenderer(string $element): RendererInterface
    {
        if (!isset($this->elementRendererMap[$element])) {
            throw new RendererException('No renderer found for element ' . $element);
        }

        $rendererClass = $this->elementRendererMap[$element];
        $rendererDependencies = $this->resolveDependencies($rendererClass);

        return new $rendererClass(...$rendererDependencies);
    }

    /**
     * Resolves the dependencies for the renderer
     *
     * @return array<\MethorZ\MarkMe\Renderer\RendererInterface>
     */
    private function resolveDependencies(string $rendererClass): array
    {
        $dependencies = [];

        if (isset($this->rendererDependencyMap[$rendererClass])) {
            foreach ($this->rendererDependencyMap[$rendererClass] as $dependencyClass) {
                $dependencies[] = new $dependencyClass(...$this->resolveDependencies($dependencyClass));
            }
        }

        return $dependencies;
    }
}
