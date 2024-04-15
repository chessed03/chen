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
                :is-change="false"
                :is-key="false"
            />
        </div>

        <div class="col-md-4">
            <x-select 
                label-component="Grupo *"
                :is-searchable="false"
                :list-items="$list_groups"
                wire-model="group_id"
                :is-change="false"
                :is-key="false"
            />
        </div>
        
        <div class="col-md-4">
            <x-select 
                label-component="Turno *"
                :is-searchable="false"
                :list-items="$list_shifts"
                wire-model="shift_id"
                :is-change="true"
                wire-change="shitfSelected(true)"
                :is-key="false"
            />
        </div>

        <div class="col-md-{{ $update_mode ? '9' : '12' }}">
            <x-select-dynamic 
                label-component="Carrera *"
                :is-searchable="false"
                wire-model="career_id"
                :is-change="false"
                :is-key="false"
            />
        </div>
        
        <div class="col-3" {{ $update_mode ? '' : 'hidden' }}>
            
            <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            
        </div>
    </div>

</x-modal-data>