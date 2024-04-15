<div class="form-group">
    <label for="{{ $wireModel }}" class="control-label">{{ $labelComponent }}</label>
    <div class="input-group clockpicker mb-1" data-autoclose="true">
        <input type="text" class="form-control" id="{{ str_replace('.', '_', $wireModel) }}" wire:model="{{ $wireModel }}" placeholder="{{ $placeholder }}" autocomplete="off">
        <div class="input-group-append">
            <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
        </div>
    </div>
    @error($wireModel)<h6> <span class="error text-danger"><i class="mdi mdi-alert-circle-outline mr-1"></i>{{ $message }}</span> </h6>@enderror
</div>

@push('scripts')

    <script>
        
        $('.clockpicker').on('change', function (e) {

            let model   = '{{ $wireModel }}';

            let data    = $('#' + model).val();
            
            @this.set(model, data);
            
        });

    </script>
    
@endpush