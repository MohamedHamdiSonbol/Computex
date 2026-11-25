{{-- resources/views/vendor/pagination/bootstrap-5.blade.php --}}

@if ($paginator->hasPages())
    <nav>
        <div class="pagination d-flex justify-content-center mt-5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="rounded disabled">&laquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="rounded" rel="prev">&laquo;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="rounded disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="#" class="active rounded">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}" class="rounded">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="rounded" rel="next">&raquo;</a>
            @else
                <span class="rounded disabled">&raquo;</span>
            @endif
        </div>
    </nav>
@endif
