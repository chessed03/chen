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

        <div class="col-md-12">
            <x-input-form 
                label-component="Nombre de la carrera *"
                input-type="text"
                wire-model="name"
                :readonly="false"
                :disabled="false"
            />
        </div>

        <div class="col-md-9">
            <x-multiselect 
                label-component="Turnos *"
                :is-searchable="false"
                :list-items="$list_shifts"
                wire-model="shifts"
                :is-change="false"
                :is-key="false"
            />
        </div>
        
            
        <div class="col-3" {{ $update_mode ? '' : 'hidden' }}>
            
            <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            
        </div>
    </div>

</x-modal-data>