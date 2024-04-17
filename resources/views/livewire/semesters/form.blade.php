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
        <div class="col-md-4">
            <x-select 
                label-component="Grado *"
                :is-searchable="false"
                :list-items="$list_degrees"
                wire-model="degree_id"
                :is-disabled="false"
                :is-change="true"
                wire-change="degreeSelected(true)"
                :is-key="false"
            />
        </div>

        <div class="col-md-4">
            <x-select 
                label-component="Grupo *"
                :is-searchable="false"
                :list-items="$list_groups"
                wire-model="group_id"
                :is-disabled="false"
                :is-change="true"
                wire-change="generateName()"
                :is-key="false"
            />
        </div>

        <div class="col-md-4">
            <x-input-form 
                label-component="Nombre del semestre"
                input-type="text"
                wire-model="name"
                :readonly="true"
                :disabled="false"
            />
        </div>

        <div class="col-md-8">
            <x-multiselect-dynamic 
                label-component="Carreras *"
                :is-searchable="false"
                wire-model="careers"
                :is-disabled="false"
                :is-change="false"
                :is-key="false"
            />
        </div>
        
        <div class="col-3" {{ $update_mode ? '' : 'hidden' }}>
            
            <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            
        </div>
    </div>

</x-modal-data>