<div class="form-group">
    <label for="{{ $wireModel }}" class="control-label">{{ $labelComponent }}</label>
    <div wire:ignore>
        <select
            @disabled($isDisabled) 
            class="selectpicker mb-1"
            data-live-search="{{ $isSearchable }}"
            data-style="btn-light"
            title="Elige una opción."
            id="{{ str_replace('.', '_', $wireModel) }}"
            wire:model.live="{{ $wireModel }}"
            @if($isChange) wire:change="{{ $wireChange }}" @endif
            @if($isKey) wire:key="{{ $wireKey }}" @endif
        >
            @foreach($listItems as $ite => $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    @error($wireModel)<h6> <span class="error text-danger"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</span> </h6>@enderror
</div>

{{-- 
    *   Cuando isChange es verdadero wireChange espera un evento/función.
    *   Evitar isChange sea verdadero si no tiene evento/función.
    *   Cuando isKey es verdadero wireKey espera una llave.
    *   Evitar isKey sea verdadero si no una llave.
    *   No respetar las reglas anteriores significan errores de funcionalidad.
    *   Ejemplo de uso: 
        <x-select 
            label-component="Turno *"
            :is-searchable="false"
            :list-items="$listShifts"
            wire-model="shift_id"
            :is-disabled="false"
            :is-change="true"
            wire-change="shitfSelected(true)"
            :is-key="false"
        />
        ! respetar los usos de (:) y no uso para las propiedades.
        ? En este ejemplo se pasa un change a true y su evento/funcion
        ! Se tiene un key en false y en su propiedad :wire-key se esta omitiendo por el false en :is-key.
        ? En caso de que el key sea true pasar su respectivo nombre entre comillas ("").
 --}}