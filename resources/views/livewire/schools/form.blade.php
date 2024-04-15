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
                label-component="Nombre de la escuela *"
                input-type="text"
                wire-model="name"
                :readonly="false"
                :disabled="false"
            />
        </div>

        <div class="col-md-9">
            <x-input-form 
                label-component="Dirección *"
                input-type="text"
                wire-model="address"
                :readonly="false"
                :disabled="false"
            />
        </div>
        
        <div class="col-md-3" {{ $update_mode ? '' : 'hidden' }}>
            
            <x-select-status-item :label-component="'Estado *'" :wire-model="'is_active'" />
            
        </div>

        <div class="col-12" {{ $update_mode ? '' : 'hidden' }}>
            <div id="accordion" class="mb-3">
                <div class="card mb-1">
                    <div class="card-header" id="headingOne">
                        <h5 class="m-0">
                            <a 
                                class="text-dark d-flex justify-content-between align-items-center"
                                data-toggle="collapse"
                                href="#collapseOne"
                                aria-expanded="true"
                                onclick="changeIcon(1)"
                            >
                                <span>
                                    <i class="mdi mdi-restore-clock mr-1"></i>
                                    Turnos
                                </span>
                                <i class="mdi mdi-plus icon-accordion"></i>
                            </a>
                        </h5>
                    </div>
        
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                @include('livewire.schools.submodules.shifts')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-header" id="headingTwo">
                        <h5 class="m-0">
                            <a 
                                class="text-dark d-flex justify-content-between align-items-center"
                                data-toggle="collapse"
                                href="#collapseTwo"
                                aria-expanded="true"
                                onclick="changeIcon(2)"
                            >
                                <span>
                                    <i class="mdi mdi-home-group mr-1"></i>
                                    Grados
                                </span>
                                <i class="mdi mdi-plus icon-accordion"></i>
                            </a>
                        </h5>
                    </div>
        
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                @include('livewire.schools.submodules.degrees')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-header" id="headingThree">
                        <h5 class="m-0">
                            <a
                                class="text-dark d-flex justify-content-between align-items-center"
                                data-toggle="collapse"
                                href="#collapseThree"
                                aria-expanded="false"
                                onclick="changeIcon(3)"
                            >
                                <span>
                                    <i class="mdi mdi-account-group mr-1"></i> 
                                    Grupos
                                </span>
                                <i class="mdi mdi-plus icon-accordion"></i>
                            </a>

                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                @include('livewire.schools.submodules.groups')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-header" id="headingFour">
                        <h5 class="m-0">
                            <a
                                class="text-dark d-flex justify-content-between align-items-center"
                                data-toggle="collapse"
                                href="#collapseFour"
                                aria-expanded="false"
                                onclick="changeIcon(4)"
                            >
                                <span>
                                    <i class="mdi mdi-hat-fedora mr-1"></i> 
                                    Puestos de personal
                                </span>
                                <i class="mdi mdi-plus icon-accordion"></i>
                            </a>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                @include('livewire.schools.submodules.staff-positions')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-1">
                    <div class="card-header" id="headingFive">
                        <h5 class="m-0">
                            <a
                                class="text-dark d-flex justify-content-between align-items-center"
                                data-toggle="collapse"
                                href="#collapseFive"
                                aria-expanded="false"
                                onclick="changeIcon(5)"
                            >
                                <span>
                                    <i class="mdi mdi-account-heart mr-1"></i> 
                                    Tipos de personal
                                </span>
                                <i class="mdi mdi-plus icon-accordion"></i>
                            </a>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="collapseFive" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                @include('livewire.schools.submodules.staff-types')
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>

    </div>

</x-modal-data>

@push('scripts')

    <script>
        
        const changeIcon = (e) => {

           const divAccordions = $('.icon-accordion');
            
           divAccordions.each((i, icon) => {

                const isOpenAccordion   = (i + 1) === e;
                const isCloseAccordion  = icon.classList.contains('mdi-plus');

                if (isOpenAccordion) {

                    if (icon.classList.contains('mdi-plus')) {
                    
                        icon.classList.remove('mdi-plus');
                        icon.classList.add('mdi-minus');

                    } else {
                        
                        icon.classList.remove('mdi-minus');
                        icon.classList.add('mdi-plus');
                    }

                } else {

                    icon.classList.remove('mdi-minus');
                    icon.classList.add('mdi-plus');

                }

            });
            
        }

    </script>
    
@endpush