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
                label-component="Nombre de la materia *"
                input-type="text"
                wire-model="name"
                :readonly="false"
                :disabled="false"
            />
        </div>

        @foreach ($courses as $index => $course)
            
            <div class="col-md-4">
                <x-select 
                    label-component="Grado *"
                    :is-searchable="false"
                    :list-items="$list_degrees"
                    wire-model="courses.{{ $index }}.degree_id"
                    :is-change="false"
                    :is-key="false"
                />
            </div>

            <div class="col-md-4">
                <x-select 
                    label-component="Carrera *"
                    :is-searchable="false"
                    :list-items="$list_careers"
                    wire-model="courses.{{ $index }}.career_id"
                    :is-change="false"
                    :is-key="false"
                />
            </div>

            <div class="col-md-2">
                <label for="">&nbsp;</label>
                <br>
                <button
                    @if (!$loop->last) @disabled(true) @endif
                    type="button"
                    class="btn btn-success waves-effect waves-light float-right"
                    wire:click="addRow({{ $index }})"
                >
                    <i class="fe-plus mr-2"></i>
                    Agregar fila
                </button>
            </div>

            <div class="col-md-2">
                <label for="">&nbsp;</label>
                <br>
                <button
                    type="button"
                    class="btn btn-danger waves-effect waves-light float-right"
                    wire:click="deleteRow({{ $index }})"
                >
                    <i class="fe-minus mr-2"></i>
                    Eliminar fila
                </button>
            </div>

        @endforeach

        <div class="col-3" {{ $update_mode ? '' : 'hidden' }}>
            
            <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            
        </div>
    </div>

</x-modal-data>