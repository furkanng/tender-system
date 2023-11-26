<div class="demo-inline-spacing">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item first">
                <a class="page-link" href="{{ $paginator->url(1) }}"><i class="tf-icon bx bx-chevrons-left"></i></a>
            </li>
            <li class="page-item prev">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i
                        class="tf-icon bx bx-chevron-left"></i></a>
            </li>

            <!-- Sayfa numaraları döngüsü -->
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item"><a class="page-link" style="background: #2a3a4c">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <li class="page-item next">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="tf-icon bx bx-chevron-right"></i></a>
            </li>
            <li class="page-item last">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}"><i
                        class="tf-icon bx bx-chevrons-right"></i></a>
            </li>
        </ul>
    </nav>
</div>
