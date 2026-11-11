{{--
    Local Mage icon. Usage:

        <x-icon name="logout" class="h-5 w-5" />
        <x-icon name="eye" class="h-4 w-4" stroke-width="1.8" />

    Icons live in resources/icons/mage/*.svg. Nothing is fetched remotely.
--}}

@props(['name'])

@php($inner = app(\App\Support\MageIcon::class)->inner($name))

@if ($inner)
    <svg {{ $attributes->merge([
        'xmlns' => 'http://www.w3.org/2000/svg',
        'viewBox' => '0 0 24 24',
        'fill' => 'none',
        'stroke' => 'currentColor',
        'stroke-width' => '1.6',
        'stroke-linecap' => 'round',
        'stroke-linejoin' => 'round',
        'width' => '24',
        'height' => '24',
        'aria-hidden' => 'true',
        'focusable' => 'false',
    ]) }}>{!! $inner !!}</svg>
@endif
