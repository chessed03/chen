
<div class="form-group" wire:ignore>
    <label for="{{ $wireModel }}" class="control-label mb-1">{{ $labelComponent }}</label>
    <select 
        class="selectpicker mb-1"
        data-style="btn-light"
        title="Elige una opción."
        id="{{ str_replace('.', '_', $wireModel) }}"
        wire:model="{{ $wireModel }}"
    >
        <option data-icon="mdi mdi-checkbox-marked-circle mr-1" value="1">Activo</option>
        <option data-icon="mdi mdi-close-circle mr-1" value="2">Inactivo</option>
    </select>
</div>