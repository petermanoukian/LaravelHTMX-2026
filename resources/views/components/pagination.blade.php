@if ($paginator->hasPages())
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">« Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" 
                       hx-get="{{ $paginator->previousPageUrl() }}"
                       hx-target="{{ $target }}"
                       hx-swap="innerHTML"
                       hx-indicator="#loading">« Previous</a>
                </li>
            @endif

            {{-- Numbers --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                <li class="page-item {{ $paginator->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}"
                       id="page{{ $page }}"
                       hx-get="{{ $url }}"
                       hx-target="{{ $target }}"
                       hx-swap="innerHTML"
                       hx-indicator="#loading">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}"
                       hx-get="{{ $paginator->nextPageUrl() }}"
                       hx-target="{{ $target }}"
                       hx-swap="innerHTML"
                       hx-indicator="#loading">Next »</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next »</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
