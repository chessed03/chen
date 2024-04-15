<div class="row">
    
    <div class="col-lg-12">

        <div class="card-box">

            <div class="row">   
                
                <div class="col-md-10">

                    <x-bar-filter-paginate-order-key :is-key-word="true" />

                </div>

                <div class="col-md-2 button-list py-3 text-right">

                    <x-button-create-item />

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
                        <td class="text-center">
                            {{ ___getPrioritiesNames__([$item->priority_id]) }}
                        </td>
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
    
    @include('livewire.schools.staff-types.form')

</div>