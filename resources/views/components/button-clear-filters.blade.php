<button
    type="button"
    @disabled($disabled)
    class="btn btn-success waves-effect waves-light float-right"
    wire:click="clearFilters()"
>
    <i class="fe-delete mr-2"></i>
    Limpar Filtro
</button>