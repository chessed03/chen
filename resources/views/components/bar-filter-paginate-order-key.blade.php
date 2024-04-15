<div class="row">
    <div class="col-md-3" wire:ignore>
        <label for="paginate_number">Mostrar</label>
        <select 
            wire:model.live="paginate_number"
            id="paginate_number"
            class="selectpicker"
        >
            <option value="5" selected>&nbsp;&nbsp;5 Registros</option>
            <option value="10">&nbsp;10 Registros</option>
            <option value="25">&nbsp;25 Registros</option>
            <option value="50">&nbsp;50 Registros</option>
            <option value="100">100 Registros</option>
        </select>
    </div>   
    <div class="col-md-3" wire:ignore>
        <label for="order_by">Ordenar</label>
        <select 
            wire:model.live="order_by"
            id="order_by"
            class="selectpicker"
        >
            <option value="1">De A a la Z</option>
            <option value="2">De Z a la A</option>
            <option value="3">Recientes primero</option>
            <option value="4">Antiguos primero</option>
        </select>
    </div>
    @if ($isKeyWord)
        <div class="col-md-6">
            <label for="key_word">Búsqueda</label>
            <input type="text" id="key_word" wire:model.live="key_word" class="form-control">
        </div>
    @endif
</div>