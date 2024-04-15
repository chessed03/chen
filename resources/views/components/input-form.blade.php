<div class="form-group">
    <label for="{{ $wireModel }}" class="control-label mb-1">{{ $labelComponent }}</label>
    <input
        type="{{ $inputType }}"
        class="form-control mb-1"
        id="{{ str_replace('.', '_', $wireModel) }}"
        wire:model="{{ $wireModel }}"
        placeholder="{{ str_replace('*', '', $labelComponent) }}"
        autocomplete="off"
        @readonly($readonly)
        @disabled($disabled)
    >
    @error($wireModel)<h6> <span class="error text-danger"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</span> </h6>@enderror
</div>