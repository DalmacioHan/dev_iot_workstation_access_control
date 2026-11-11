@php
    $stepperBase = request()->except(['step', 'page']);

    $stepperUrl = fn (int $target): string => route(
        'reports.index',
        array_merge($stepperBase, ['step' => $target])
    );
@endphp

<div class="border-b border-gray-100 bg-gray-50/60 px-5 py-4 sm:px-7">

    {{-- Mobile progress --}}
    <div class="sm:hidden">

        <div class="flex items-center justify-between text-xs font-semibold">

            <span class="text-blue-600">
                Step {{ $step }} of 4 · {{ $stepLabels[$step] }}
            </span>

            <span class="text-gray-400">
                {{ $step }}/4
            </span>

        </div>

        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-gray-200">

            <div class="h-full rounded-full bg-blue-600 transition-all" style="width: {{ $step * 25 }}%"></div>

        </div>

    </div>


    {{-- Desktop steps --}}
    <ol class="hidden items-center sm:flex">

        @foreach ($stepLabels as $number => $label)

            <li class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">

                <a href="{{ $stepperUrl($number) }}" class="group flex items-center gap-2.5">

                    <span
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-bold transition
                        {{ $number < $step
                            ? 'bg-blue-600 text-white'
                            : ($number === $step
                                ? 'bg-blue-600 text-white ring-4 ring-blue-100'
                                : 'bg-gray-100 text-gray-400 group-hover:bg-gray-200') }}"
                    >

                        @if ($number < $step)

                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m5 13 4 4L19 7" />
                            </svg>

                        @else

                            {{ $number }}

                        @endif

                    </span>


                    <span
                        class="text-sm font-semibold transition
                        {{ $number === $step
                            ? 'text-gray-900'
                            : ($number < $step
                                ? 'text-gray-600 group-hover:text-gray-900'
                                : 'text-gray-400 group-hover:text-gray-600') }}"
                    >
                        {{ $label }}
                    </span>

                </a>


                @if (! $loop->last)

                    <span class="mx-3 h-px flex-1 {{ $number < $step ? 'bg-blue-200' : 'bg-gray-200' }}"></span>

                @endif

            </li>

        @endforeach

    </ol>

</div>
