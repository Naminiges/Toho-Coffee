@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }} dari {{ $paginator->total() }} hasil
        </div>
        
        <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="page-link disabled">
                    <i class="fas fa-chevron-left"></i>
                    Sebelumnya
                </span>
            @else
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <i class="fas fa-chevron-left"></i>
                    Sebelumnya
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-link disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    Selanjutnya
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="page-link disabled">
                    Selanjutnya
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </nav>
    </div>
@endif