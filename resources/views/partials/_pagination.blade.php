@php ($link_limit = 7)

@if ($paginator->hasPages())
  <nav class="pagination is-centered" role="navigation" aria-label="pagination">
    {{-- Previous Page Link --}}
    {{-- @if ($paginator->onFirstPage())
      <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
    @else --}}
      <a href="{{ $paginator->previousPageUrl() }}" class="pagination-previous" rel="prev" {{ ($paginator->onFirstPage()) ? 'disabled' : '' }}>&laquo; Previous</a>
      <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next" rel="next" {{ ($paginator->hasMorePages()) ? '' : 'disabled' }}>Next &raquo;</a>
      {{-- <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li> --}}
    {{-- @endif --}}

    {{-- Pagination Elements --}}
    {{-- {{ dd($paginator) }} --}}
    <ul class="pagination-list">
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}

        @if (is_string($element))

          <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            {{-- @if ($page == $paginator->currentPage())
              <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li> --}}
              <li><a href="{{ $url }}" class="pagination-link {{ $page == $paginator->currentPage() ? 'is-current' : '' }}" aria-label="{{ $page }}">{{ $page }}</a></li>
            {{-- @endif --}}
          @endforeach
        @endif
      @endforeach
    </ul>


    {{-- Next Page Link --}}
    {{-- @if ($paginator->hasMorePages()) --}}
      {{-- <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li> --}}
    {{-- @else
      <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
    @endif --}}
  </nav>
@endif
