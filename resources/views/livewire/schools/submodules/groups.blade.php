<div class="col-12">

    <div class="table-responsive">
    
        <table class="table mb-0">
            <thead>
                <tr>
                    <th width="80%">Grupos</th>
                    <th width="20%" class="text-right">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @foreach ($list_groups as $item)
                            <span class="badge badge-light-primary badge-pil" style="font-size: 1em">{{ $item->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-right">
                        <x-button-route
                            name-button="Ir a grupos"
                            route="school.group.index"
                        >
                        </x-button-route>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>

</div>