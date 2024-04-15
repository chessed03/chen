<div class="col-12">

    <div class="table-responsive">
    
        <table class="table mb-0">
            <thead>
                <tr>
                    <th width="80%">Turnos</th>
                    <th width="20%" class="text-right">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @foreach ($list_shifts as $item)
                            <span class="badge badge-light-primary badge-pil" style="font-size: 1em">{{ $item->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-right">
                        <x-button-route
                            name-button="Ir a Turnos"
                            route="school.shift.index"
                        >
                        </x-button-route>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>

</div>