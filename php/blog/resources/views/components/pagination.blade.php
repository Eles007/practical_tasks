@if($paginator->hasPages())
    <nav
        class="inline-flex items-center gap-2 mt-4"
        role="navigation"
        aria-label="Pagination"
    >
        @if($paginator->onFirstPage())
            <span class="px-3 py-2 rounded-lg border border-white/10 hover:border-fuchsia-500/40">
                    &lt;
                </span>
        @else
            <a
                href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-2 rounded-lg border border-white/10 hover:border-fuchsia-500/40"
            >
                &lt;
            </a>
        @endif

        @foreach($elements as $element)
            @if(is_string($element))
                <span
                    class="px-3 py-2 rounded-lg bg-fuchsia-500/20 text-gray-500 border">{{$element}}</span>
            @endif
            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <span
                            class="px-3 py-2 rounded-lg bg-fuchsia-500/20 border border-fuchsia-500/30">{{$page}}</span>
                    @else
                        <a href="{{$url}}"
                           class="px-3 py-2 rounded-lg bg-fuchsia-500/80 border border-fuchsia-500/30">{{$page}}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                class="px-3 py-2 rounded-lg border border-white/10 hover:border-fuchsia-500/40"
            >
                &gt;
            </a>
        @else
            <span class="px-3 py-2 rounded-lg border border-white/10 hover:border-fuchsia-500/40">
                    &gt;
                </span>
        @endif
    </nav>
@endif
