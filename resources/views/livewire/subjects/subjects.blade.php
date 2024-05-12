<div class="row">
    
    <div class="col-lg-12">

        <div class="card-box">

            <div class="row" x-data="{ openBarFilters: false }">   
                
                <div class="col-md-9">

                    <x-bar-filter-paginate-order-key :is-key-word="true" />

                </div>

                <div class="col-md-3 button-list py-3">

                    <x-button-create-item />

                    <button
                        type="button"
                        x-on:click="openBarFilters =! openBarFilters"
                        x-bind:class="{'btn-success': !openBarFilters, 'btn-danger': openBarFilters}"
                        class="btn waves-effect waves-light float-right"
                    >
                        <i x-bind:class="{'fe-filter mr-1': !openBarFilters, 'fe-x mr-1': openBarFilters}"></i> 
                        <span x-text="openBarFilters ? 'Cerrar filtros' : 'Ver filtros'"></span>
                    </button>

                </div>
                
                <div class="col-md-9" 
                    x-show="openBarFilters"
                    x-transition.scale.origin.top
                >

                    <div class="row">
                        <div class="col-md-4">

                            <x-select 
                                label-component="Tipo de materia"
                                :is-searchable="false"
                                :list-items="$list_subject_types"
                                wire-model="selected_subject_type_id"
                                :is-disabled="false"
                                :is-change="false"
                                :is-key="false"
                            />
                    
                        </div>
                        
                        <div class="col-md-4">

                            <x-select 
                                label-component="Referencia de grado"
                                :is-searchable="false"
                                :list-items="$list_degree_references"
                                wire-model="selected_degree_reference_id"
                                :is-disabled="false"
                                :is-change="false"
                                :is-key="false"
                            />
                                              
                        </div>

                        <div class="col-md-4">

                            <x-select 
                                label-component="Carreras"
                                :is-searchable="false"
                                :list-items="$list_careers"
                                wire-model="selected_career_id"
                                :is-disabled="false"
                                :is-change="false"
                                :is-key="false"
                            />
                                              
                        </div>

                    </div>

                </div>
               
                <div class="col-md-3 button-list py-3 text-right" 
                    x-show="openBarFilters"
                    x-transition.scale.origin.top
                >

                    <x-button-clear-filters 
                        :disabled="!$selected_subject_type_id && !$selected_degree_reference_id && !$selected_career_id"
                    />
             
                </div>
                
            </div>

            <x-table-data 
                :is-empty-list="$listModule->isEmpty()"
                :headers-table="$headers_table"
                :wire-targets="$action_loader"
            >
                            
                @foreach ($listModule as $key => $item)

                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ ___getTypeSubjectsNames___([$item->subject_type_id]) }}</td>
                        <td class="text-center">{{ $item->degree_reference_id }}</td>
                        <td>{{ ___getCareersNames___($item->careers) }}</td>
                        <td class="text-center">
            
                            <x-status-item :is-active="$item->is_active" />

                        </td>
                        <td class="text-right">
                            
                            <x-button-update-item :item-id="$item->id" />
                            
                            <x-button-delete-item :item-id="$item->id" :item-name="$item->name" />
                            
                        </td>
                    </tr>
                    
                @endforeach
        
                <x-slot:footer>
                        
                    <x-pagination :list-module="$listModule" />
                                                
                </x-slot>
                
            </x-table-data>

        </div>

    </div>

    @include('livewire.subjects.form')

</div>