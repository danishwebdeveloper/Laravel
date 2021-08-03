@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center pg-20">
    <ul class="pagination">
        @if ($paginator->onFirstPage())
        @else
            <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><</a></li>
        @endif
			@foreach ($elements as $element)           
            @if (is_string($element))
                <li class="page-item disabled"><span>{{ $element }}</span></li>
            @endif           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active page-item"><span>{{ $page }}</span></li>
                    @else
                        <li class=" page-item"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
    	@if ($paginator->hasMorePages())
            <li class=" page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next">></a></li>
        @endif
    </ul>
  </nav>
@endif 