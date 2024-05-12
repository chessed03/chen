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
                                label-component="Grado"
                                :is-searchable="false"
                                :list-items="$list_degrees"
                                wire-model="selected_degree_id"
                                :is-disabled="false"
                                :is-change="false"
                                :is-key="false"
                            />
                    
                        </div>
                        
                        <div class="col-md-4">

                            <x-select 
                                label-component="Grupo"
                                :is-searchable="false"
                                :list-items="$list_groups"
                                wire-model="selected_group_id"
                                :is-disabled="false"
                                :is-change="false"
                                :is-key="false"
                            />
                                              
                        </div>

                        <div class="col-md-4">

                            <x-select 
                                label-component="Carrera"
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
                        :disabled="!$selected_degree_id && !$selected_group_id && !$selected_career_id"
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
                        <td>{{ $item->degree->name }}</td>
                        <td class="text-center">
                            {{ $item->group->name }}
                        </td>
                        <td>{{ ___getCareersNames___($item->careers) }}</td>
                        <td class="text-center">
                            
                            <x-status-item :is-active="$item->is_active" />
                            
                        </td>
                        <td class="text-right">
                        
                            <x-button-update-item :item-id="$item->id" />
                            
                            <x-button-delete-item :item-id="$item->id" :item-name="$item->degree->name . ' ' . $item->group->name" />
                            
                        </td>
                    </tr>
                    
                @endforeach

                <x-slot:footer>
                    
                    <x-pagination :list-module="$listModule" />
                                                
                </x-slot>
                
            </x-table-data>

        </div>

    </div>

    @include('livewire.semesters.form')

</div>