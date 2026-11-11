<?php

namespace App\Support;

/**
 * Reads the locally bundled Mage icon set.
 *
 * The raw SVGs ship with `stroke="black"` and a fixed `stroke-width`, which
 * would ignore Tailwind text colours. This class strips the outer <svg>
 * wrapper and hoists the presentation attributes to the Blade component's
 * root element, where they are set to `currentColor` and the caller's width.
 */
class MageIcon
{
    /** @var array<string, string|null> */
    protected static array $cache = [];

    /**
     * Inner markup of an icon (everything inside <svg>), or null when the
     * icon does not exist locally.
     */
    public static function inner(string $name): ?string
    {
        $name = self::normalize($name);

        if (array_key_exists($name, self::$cache)) {
            return self::$cache[$name];
        }

        $path = resource_path("icons/mage/{$name}.svg");

        if (! is_file($path)) {
            return self::$cache[$name] = null;
        }

        $svg = (string) file_get_contents($path);

        // Drop the outer <svg> element; the component renders its own.
        $inner = preg_replace('/^.*?<svg\b[^>]*>/s', '', $svg) ?? $svg;
        $inner = preg_replace('/<\/svg>\s*$/s', '', $inner) ?? $inner;

        // Presentation is owned by the component root, so remove it from the
        // individual paths. Longest names first so `stroke` never eats
        // `stroke-width` or `stroke-linecap`.
        $inner = preg_replace(
            '/\s+(?:stroke-width|stroke-linecap|stroke-linejoin|stroke-miterlimit|stroke)="[^"]*"/i',
            '',
            $inner
        ) ?? $inner;

        return self::$cache[$name] = trim($inner);
    }

    public static function exists(string $name): bool
    {
        return self::inner($name) !== null;
    }

    /**
     * @return list<string>
     */
    public static function names(): array
    {
        $paths = glob(resource_path('icons/mage/*.svg')) ?: [];

        $names = array_map(
            fn (string $path): string => basename($path, '.svg'),
            $paths
        );

        sort($names);

        return array_values($names);
    }

    private static function normalize(string $name): string
    {
        return strtolower(trim($name));
    }
}
