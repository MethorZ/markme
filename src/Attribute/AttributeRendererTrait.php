<?php

declare(strict_types = 1);

namespace MethorZ\MarkMe\Attribute;

/**
 * Trait defining attribute rendering
 *
 * @package MethorZ\MarkMe\Attribute
 * @author Thorsten Merz <methorz@spammerz.de>
 * @copyright MethorZ
 */
trait AttributeRendererTrait
{
    /**
     * Renders the attributes
     *
     * @param array<\MethorZ\MarkMe\Attribute\Attribute> $attributes
     */
    private function renderAttributes(array $attributes): string
    {
        $ids = [];
        $classes = [];
        $styles = [];
        $keyValues = [];

        foreach ($attributes as $attribute) {
            if ($attribute->isId()) {
                $ids[] = $attribute->getValue();
            } elseif ($attribute->isClass()) {
                $classes[] = $attribute->getValue();
            } elseif ($attribute->isStyle()) {
                $styles[] = $attribute->getValue();
            } elseif ($attribute->isKeyValue()) {
                $keyValues[] = $attribute->getValue();
            }
        }

        $renderedAttributes = '';

        // Render ids
        if (!empty($ids)) {
            $renderedAttributes .= ' id="' . implode(' ', $ids) . '"';
        }

        // Render classes
        if (!empty($classes)) {
            $renderedAttributes .= ' class="' . implode(' ', $classes) . '"';
        }

        // Render styles
        if (!empty($styles)) {
            $renderedAttributes .= ' style="' . implode(' ', $styles) . '"';
        }

        // Render key value attributes
        if (!empty($keyValues)) {
            foreach ($keyValues as $keyValue) {
                $renderedAttributes .= ' ' . $keyValue;
            }
        }

        return $renderedAttributes;
    }
}
