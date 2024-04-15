<div wire:loading wire:target="{{ $wireTargets }}" class="table-responsive mt-4">
    <table class="table mb-0">
        <thead class="thead-light">
            <thead>
                <tr>
                    @foreach ($headersTable as $header)
                        <th width="{{ $header->width }}" class="{{ $header->class }}">{{ $header->name }}</th>
                    @endforeach
                </tr>
            </thead>
        </thead>
        <tbody class="table-borderless">
            <tr>
                <td class="text-center justify-items-center align-middle" rowspan="2" colspan="{{ count($headersTable) }}"">
                    <div class="spinner-border" role="status"></div> 
                    <br>   
                    <div class="mt-2">
                        <strong>Cargando datos..</strong>
                    </div>
                </td>
            </tr>
            <tr style="height: 350px;"></tr>
        </tbody>
    </table>
</div>

@if ($isEmptyList)
    <div class="table-responsive mt-4" wire:loading.attr="hidden" wire:target="{{ $wireTargets }}">
        <table class="table mb-0">
            <thead>
                <tr>
                    @foreach ($headersTable as $header)
                        <th width="{{ $header->width }}" class="{{ $header->class }}">{{ $header->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="table-borderless">
                <tr>
                    <td class="text-center justify-items-center align-middle" rowspan="2" colspan="{{ count($headersTable) }}">
                        <strong>Sin resultados.</strong>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr style="height: 355px;"></tr>
            </tbody>
        </table>
    </div>
@endif

@if (!$isEmptyList)
    <div class="table-responsive mt-4" wire:loading.attr="hidden" wire:target="{{ $wireTargets }}">

        <table class="table mb-0">
            <thead>
                <tr>
                    @foreach ($headersTable as $header)
                        <th width="{{ $header->width }}" class="{{ $header->class }}">{{ $header->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
        
        <hr>
        
        {{ $footer }}

    </div>
@endif