@if($isTeacher == 1)

    <span class="badge badge-light-primary" style="font-size: 1em">
        <i class="mdi mdi-folder-account mr-1"></i>
        Frente a clase
    </span>

@elseif($isTeacher == 2)

    <span class="badge badge-light-secondary" style="font-size: 1em">
        <i class="mdi mdi-folder mr-1"></i>
        Sin clase
    </span>
    
@endif