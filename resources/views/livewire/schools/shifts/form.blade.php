<x-modal-data :modal-title="$modal_title">

    <p class="sub-header">
        @foreach ($modal_warnings as $warning)
            <i class="mdi mdi-chevron-right"></i> {{ $warning }}.
            @if (!$loop->last)
                <br>
            @endif
        @endforeach
    </p>

    <div class="row">

        <div class="col-md-6">
            <x-input-form 
                label-component="Nombre del turno *"
                input-type="text"
                wire-model="name"
                :readonly="false"
                :disabled="false"
            />
        </div>
        
        <div class="col-md-6">
            <x-input-form 
                label-component="Referencia *"
                input-type="number"
                wire-model="reference"
                :readonly="false"
                :disabled="false"
            />
        </div> 

        <div class="col-md-4">
            <x-input-clock 
                label-component="Hora de inicio *"
                wire-model="hour_init"
                placeholder="Selecciona una hora de inicio."
            />
        </div>

        <div class="col-md-4">
            <x-input-clock 
                label-component="Hora de cierre *"
                wire-model="hour_finish"
                placeholder="Selecciona una hora de cierre."
            />
        </div>
        
        <div class="col-md-1"></div>

        <div class="col-md-3" {{ $update_mode ? '' : 'hidden' }}>
            
            <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            
        </div>
        
    </div>

</x-modal-data>