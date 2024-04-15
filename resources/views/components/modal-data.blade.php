<div wire:ignore.self class="modal fade" id="modalForm" role="dialog" aria-labelledby="labelModalForm" aria-hidden="true" style="display: none;" data-backdrop="static">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="labelModalForm">{{ $modalTitle }}</h4>
                <button type="button" class="close" wire:click="closeModal()" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">

                {{ $slot }}

            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger waves-effect waves-light" wire:click="closeModal()"><i class="fe-x mr-1"></i> Cerrar</button>
                <button type="button" class="btn btn-dark waves-effect waves-light" wire:click.prevent="saveItem()"><i class="fe-save mr-1"></i> Guardar</button>
            </div>

        </div>
        
    </div>

</div>