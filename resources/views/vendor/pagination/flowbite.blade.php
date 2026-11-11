@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center">
        <ul class="inline-flex items-center -space-x-px text-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium font-medium rounded-s-base text-sm w-9 h-9 opacity-50 pointer-events-none">
                        <span class="sr-only">Previous</span>
                        <x-icon name="chevron-left" class="w-4 h-4" aria-hidden="true" />
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium rounded-s-base text-sm w-9 h-9 focus:outline-none">
                        <span class="sr-only">Previous</span>
                        <x-icon name="chevron-left" class="w-4 h-4" aria-hidden="true" />
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium font-medium text-sm w-9 h-9">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="flex items-center justify-center text-fg-brand bg-neutral-tertiary-medium box-border border border-default-medium font-medium text-sm w-9 h-9">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium text-sm w-9 h-9 focus:outline-none">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium rounded-e-base text-sm w-9 h-9 focus:outline-none">
                        <span class="sr-only">Next</span>
                        <x-icon name="chevron-right" class="w-4 h-4" aria-hidden="true" />
                    </a>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium font-medium rounded-e-base text-sm w-9 h-9 opacity-50 pointer-events-none">
                        <span class="sr-only">Next</span>
                        <x-icon name="chevron-right" class="w-4 h-4" aria-hidden="true" />
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif