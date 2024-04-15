<div class="mt-2 d-flex justify-content-center">
    <nav>
        <ul class="pagination pagination-rounded">
            <li class="page-item {{ $listModule->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $listModule->previousPageUrl() }}" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Anterior</span>
                </a>
            </li>

            {!! $listModule->links() !!}

            <li class="page-item {{ !$listModule->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $listModule->nextPageUrl() }}" aria-label="Siguiente">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </li>

        </ul>
    </nav>

</div>