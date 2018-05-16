@php ($link_limit = 7)

@if ($paginator->hasPages())
  <nav class="pagination is-centered" role="navigation" aria-label="pagination">
    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-previous" rel="prev" {{ ($paginator->onFirstPage()) ? 'disabled' : '' }}>&laquo; Ankstesnis</a>
    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next" rel="next" {{ ($paginator->hasMorePages()) ? '' : 'disabled' }}>Sekantis &raquo;</a>

    {{-- Pagination Elements --}}
    <ul class="pagination-list">
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}

        @if (is_string($element))

          <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            <li><a href="{{ $url }}" class="pagination-link {{ $page == $paginator->currentPage() ? 'is-current' : '' }}" aria-label="{{ $page }}">{{ $page }}</a></li>
          @endforeach
        @endif
      @endforeach
    </ul>
  </nav>
@endif
