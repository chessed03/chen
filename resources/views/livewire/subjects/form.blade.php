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
        
        <div class="col-md-8">
            <x-input-form 
                label-component="Nombre de la materia *"
                input-type="text"
                wire-model="name"
                :readonly="false"
                :disabled="false"
            />
        </div>

        <div class="col-md-4">
            <x-select 
                label-component="Tipo de materia *"
                :is-searchable="false"
                :list-items="$list_subject_type"
                wire-model="subject_type_id"
                :is-disabled="false"
                :is-change="true"
                wire-change="subjectTypeSelected(true)"
                :is-key="false"
            />
        </div>

        <div class="col-md-2">
            <x-select 
                label-component="Referencia de grado *"
                :is-searchable="false"
                :list-items="$list_degree_references"
                wire-model="degree_reference_id"
                :is-disabled="false"
                :is-change="false"
                :is-key="false"
            />
        </div>

        <div class="col-md-7">
            <div class="form-group" wire:ignore>
                <label class="control-label mb-1">Carreras *</label>
                <div id="divChangeContentCareers"></div>
            </div>
        </div>

        <div class="col-3" {{ $update_mode ? '' : 'hidden' }}>
            
            <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            
        </div>
    </div>

</x-modal-data>