<?php

use App\Support\MageIcon;
use Illuminate\Support\Facades\Blade;

it('loads and normalises a local mage icon', function () {
    $inner = MageIcon::inner('logout');

    expect($inner)->not->toBeNull();
    expect($inner)->toContain('<path');
    expect($inner)->not->toContain('<svg');
    expect($inner)->not->toContain('stroke="black"');
    expect($inner)->not->toContain('stroke-width');
});

it('renders icons with currentColor instead of the hardcoded black stroke', function () {
    $html = Blade::render('<x-icon name="logout" class="h-5 w-5" />');

    expect($html)->toContain('stroke="currentColor"');
    expect($html)->toContain('class="h-5 w-5"');
    expect($html)->toContain('viewBox="0 0 24 24"');
    expect($html)->not->toContain('stroke="black"');
});

it('lets callers override the stroke width', function () {
    $html = Blade::render('<x-icon name="eye" stroke-width="1.2" />');

    expect($html)->toContain('stroke-width="1.2"');
});

it('renders nothing for an icon that does not exist', function () {
    expect(MageIcon::exists('does-not-exist'))->toBeFalse();
    expect(Blade::render('<x-icon name="does-not-exist" />'))->toBe('');
});

it('has a local file for every icon referenced in the views', function () {
    $views = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(resource_path('views'))
    );

    $missing = [];

    foreach ($views as $file) {
        if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) {
            continue;
        }

        $contents = file_get_contents($file->getPathname());

        preg_match_all('/<x-icon\s+name="([^"]+)"/', $contents, $matches);

        foreach ($matches[1] as $name) {
            if (! MageIcon::exists($name)) {
                $missing[] = $name.' ('.$file->getFilename().')';
            }
        }
    }

    expect(array_values(array_unique($missing)))->toBe([]);
});
