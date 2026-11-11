@php
    $except = array_merge(['step', 'page'], $except ?? []);
@endphp

@foreach (request()->query() as $key => $value)

    @continue(in_array($key, $except, true))

    @if (is_array($value))

        @foreach ($value as $subKey => $subValue)

            @if (! is_array($subValue))

                <input
                    type="hidden"
                    name="{{ $key }}[{{ $subKey }}]"
                    value="{{ $subValue }}"
                >

            @endif

        @endforeach

    @else

        <input
            type="hidden"
            name="{{ $key }}"
            value="{{ $value }}"
        >

    @endif

@endforeach
