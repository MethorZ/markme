<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe;

use MethorZ\MarkMe\Element\BlockQuote;
use MethorZ\MarkMe\Element\Comment;
use MethorZ\MarkMe\Element\Custom\Tag;
use MethorZ\MarkMe\Element\Heading;
use MethorZ\MarkMe\Element\HorizontalRule;
use MethorZ\MarkMe\Element\Inline\Text;
use MethorZ\MarkMe\Element\ListBlock;
use MethorZ\MarkMe\Element\ListItem;
use MethorZ\MarkMe\Element\NewLine;
use MethorZ\MarkMe\Element\Paragraph;
use MethorZ\MarkMe\Exception\RendererException;
use MethorZ\MarkMe\Renderer\BlockQuoteRenderer;
use MethorZ\MarkMe\Renderer\CommentRenderer;
use MethorZ\MarkMe\Renderer\HeadingRenderer;
use MethorZ\MarkMe\Renderer\HorizontalRuleRenderer;
use MethorZ\MarkMe\Renderer\ImageRenderer;
use MethorZ\MarkMe\Renderer\ListBlockRenderer;
use MethorZ\MarkMe\Renderer\ListItemRenderer;
use MethorZ\MarkMe\Renderer\NewLineRenderer;
use MethorZ\MarkMe\Renderer\ParagraphRenderer;
use MethorZ\MarkMe\Renderer\RendererInterface;
use MethorZ\MarkMe\Renderer\TagRenderer;
use MethorZ\MarkMe\Renderer\TextRenderer;

/**
 * Abstract Markdown
 *
 * @package MethorZ\MarkMe
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
abstract class AbstractMarkdown
{
    /**
     * Parsed elements
     *
     * @var array<\MethorZ\MarkMe\Element\ElementInterface>
     */
    protected array $parsedElements = [];

    /**
     * Cache for renderers
     *
     * @var array<string,\MethorZ\MarkMe\Renderer\RendererInterface>
     */
    private array $rendererCache = [];

    /**
     * Map of element renderers
     *
     * @var array<string,string>
     */
    private array $elementRendererMap = [
        BlockQuote::class => BlockQuoteRenderer::class,
        Comment::class => CommentRenderer::class,
        Heading::class => HeadingRenderer::class,
        HorizontalRule::class => HorizontalRuleRenderer::class,
        ListBlock::class => ListBlockRenderer::class,
        ListItem::class => ListItemRenderer::class,
        NewLine::class => NewLineRenderer::class,
        Paragraph::class => ParagraphRenderer::class,
        Tag::class => TagRenderer::class,
        Text::class => TextRenderer::class,
    ];

    /**
     * Map of renderer dependencies
     *
     * @var array<string,array<string>>
     */
    private array $rendererDependencies = [
        BlockQuoteRenderer::class => [ParagraphRenderer::class],
        ListBlockRenderer::class => [ListItemRenderer::class],
        ListItemRenderer::class => [TextRenderer::class],
        ParagraphRenderer::class => [TextRenderer::class],
        TextRenderer::class => [ImageRenderer::class, TagRenderer::class],
    ];

    /**
     * Renders the markdown to html
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     * @throws \MethorZ\MarkMe\Exception\ParseException
     * @throws \MethorZ\MarkMe\Exception\IdentificationException
     */
    abstract public function html(string $markdown): string;

    /**
     * Constructor
     */
    public function __construct(
        protected readonly Parser $parser
    ) {
    }

    /**
     * Sets a specific renderer for an element
     *
     * This method can be used to set a specific renderer for an new element or overwrite existing element renderers with custom logic.
     * If the renderer has dependencies, they can be defined in the $rendererDependencies parameter
     *
     * @param array<string> $rendererDependencyClasses
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    public function setRenderer(
        string $elementClass,
        string $rendererClass,
        array $rendererDependencyClasses = []
    ): void {

        if (!class_exists($elementClass)) {
            throw new RendererException('Element class does not exist: ' . $elementClass);
        }

        if (!class_exists($rendererClass)) {
            throw new RendererException('Renderer class does not exist: ' . $rendererClass);
        }

        foreach ($rendererDependencyClasses as $dependencyClass) {
            if (!class_exists($dependencyClass)) {
                throw new RendererException('Renderer dependency does not exist: ' . $dependencyClass);
            }
        }

        $this->elementRendererMap[$elementClass] = $rendererClass;

        if (!empty($rendererDependencyClasses)) {
            $this->rendererDependencies[$rendererClass] = $rendererDependencyClasses;
        }
    }

    /**
     * Returns the renderer for the element
     *
     * @throws \MethorZ\MarkMe\Exception\RendererException
     */
    protected function getRenderer(string $element): RendererInterface
    {
        if (!isset($this->elementRendererMap[$element])) {
            throw new RendererException('No renderer found for element ' . $element . ' - Add a custom renderer using the setRenderer method.');
        }

        // Get the requested renderer class
        $rendererClass = $this->elementRendererMap[$element];

        // Add or retrieve from/to cache
        $this->rendererCache[$rendererClass] ??= new $rendererClass(...$this->resolveDependencies($rendererClass));

        return $this->rendererCache[$rendererClass];
    }

    /**
     * Resolves the dependencies for the renderer
     *
     * @return array<\MethorZ\MarkMe\Renderer\RendererInterface>
     */
    private function resolveDependencies(string $rendererClass): array
    {
        $dependencies = [];

        if (isset($this->rendererDependencies[$rendererClass])) {
            foreach ($this->rendererDependencies[$rendererClass] as $dependencyClass) {
                $this->rendererCache[$dependencyClass] ??= new $dependencyClass(...$this->resolveDependencies($dependencyClass));
                $dependencies[] = $this->rendererCache[$dependencyClass];
            }
        }

        return $dependencies;
    }
}
