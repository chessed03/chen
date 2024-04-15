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
            <x-select 
                label-component="Referencia *"
                :is-searchable="false"
                :list-items="$list_degree_references"
                wire-model="degree_reference_id"
                :is-change="true"
                wire-change="generateName()"
                :is-key="false"
            />
        </div>

        <div class="col-md-6">
            <x-select 
                label-component="Turno *"
                :is-searchable="false"
                :list-items="$list_shifts"
                wire-model="shift_id"
                :is-change="true"
                wire-change="generateName()"
                :is-key="false"
            />
        </div>

        <div class="col-md-6">
            <x-input-form 
                label-component="Nombre del grado *"
                input-type="text"
                wire-model="name"
                :readonly="true"
                :disabled="false"
            />
        </div>    

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label mb-1">Período <span class="text-muted">dato informativo</span></label>
                <input
                    type="text"
                    class="form-control mb-1"
                    autocomplete="off"
                    value="{{ $selected_period }}"
                    @readonly(true)
                >
            </div>            
        </div>

        <div class="col-md-3" {{ $update_mode ? '' : 'hidden' }}>
            
            <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            
        </div>
        
    </div>

</x-modal-data>