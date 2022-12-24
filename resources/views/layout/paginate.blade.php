<div class="flex items-center justify-center gap-3">

    @if ($paginator->onFirstPage())
        <span class="text-slate-600 flex bg-gray-50 items-center justify-center rounded border w-9 h-9 shadow">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
        </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="transition flex bg-white items-center justify-center rounded-md border w-9 h-9 shadow hover:bg-gray-50">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
        </svg>
    </a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
        <span class="flex bg-white items-center justify-center rounded-md border w-9 h-9 shadow hover:bg-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </span>
        @else
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span href="{{ $url }}" class="font-medium text-sm flex bg-blue-600 text-white items-center justify-center rounded-md border w-9 h-9 shadow0">{{ $page }}</span>
                @else
                <a href="{{ $url }}" class="transition font-medium text-sm flex bg-white items-center justify-center rounded-md border w-9 h-9 shadow hover:bg-gray-50">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->onLastPage())
    <span class="text-slate-600 flex bg-gray-50 items-center justify-center rounded-md border w-9 h-9 shadow">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
        </svg>
    </span>
    @else
    <a href="{{ $paginator->nextPageUrl() }}" class="transition flex bg-white items-center justify-center rounded-md border w-9 h-9 shadow hover:bg-gray-50">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
        </svg>
    </a>
    @endif


</div>