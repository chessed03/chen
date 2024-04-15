@if($isActive == 1)

    <span class="badge badge-success badge-pill">
        <i class="mdi mdi-checkbox-marked-circle mr-1"></i>
        Activo
    </span>

@elseif($isActive == 2)

    <span class="badge badge-secondary badge-pill">
        <i class="mdi mdi-close-circle mr-1"></i>
        Inactivo
    </span>
    
@endif