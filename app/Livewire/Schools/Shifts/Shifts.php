<?php

namespace App\Livewire\Schools\Shifts;

use App\Livewire\Traits\DispatchServices;
use App\Models\School\Shift\Shift;
use Livewire\WithPagination;
use Livewire\Component;

class Shifts extends Component
{

    use DispatchServices;
    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners        = ['disabledItem'];
    
    public $paginate_number     = 5;

    public $order_by            = 3;

    public $action_loader, $headers_table, $modal_title, $modal_warnings, $modal_target, $key_word, $selected_id, $update_mode;

    public $name, $reference, $hour_init, $hour_finish, $is_active;

    public function mount()
    {

        $this->action_loader    = "paginate_number, order_by, key_word";

        $this->headers_table    = [
            (object)['name' => 'Nombre', 'class' => '', 'width' => '35%'],
            (object)['name' => 'Referencia', 'class' => 'text-center', 'width' => '10%'],
            (object)['name' => 'Hora de inicio', 'class' => 'text-center', 'width' => '15%'],
            (object)['name' => 'Hora de cierre', 'class' => 'text-center', 'width' => '15%'],
            (object)['name' => 'Estado', 'class' => 'text-center', 'width' => '10%'],
            (object)['name' => 'Acciones', 'class' => 'text-right', 'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Los campos marcados con (*) son obligatorios',
            'El formato de horario es de 24 hrs.'
        ];

    }

    public function validateData()
    {
    
        $this->validateRegister();

        $rules = [
            'name'          => 'required',
            'reference'     => 'required',
            'hour_init'     => 'required|date_format:H:i|before:hour_finish',
            'hour_finish'   => 'required|date_format:H:i|after:hour_init',
        ];

        if ($this->update_mode) {

            $rules['is_active'] = 'required';

        }        
        
        $messages = [
            'required'          => 'El campo es requerido.',
            'hour_init.before'  => 'La hora de inicio debe ser anterior a la hora de cierre.',
            'hour_finish.after' => 'La hora de cierre debe ser posterior a la hora de inicio.',
        ];
        
        $this->validate($rules, $messages);

    }

    private function resetFieldsAndHydrate()
    {
        $this->selected_id  = null;
        $this->name         = null;
        $this->reference    = null;
        $this->hour_init    = null;
        $this->hour_finish  = null;
        $this->is_active    = null;
        $this->update_mode  = false;

        $this->dsSelectSelected('is_active', null);
        $this->resetErrorBag();
        $this->resetValidation();

    }

    public function openModal($modal_target, $modal_title, $selected_id)
    {

        $this->resetFieldsAndHydrate();
        $this->modal_title  = $modal_title;
        $this->modal_target = $modal_target;
        $this->update_mode  = $selected_id ? true : false;
        
        if ($this->update_mode) {

            $this->selected_id  = $selected_id;
            $this->getItemById();

        }

        $this->dsOpenModal($this->modal_target);

    }

    public function closeModal()
    {
        
        $this->dsCloseModal($this->modal_target);
        $this->resetFieldsAndHydrate();

    }

    public function getItemById()
    {
        
        $item               = Shift::getItemById($this->selected_id);
        $this->name         = $item->name;
        $this->reference    = $item->reference;
        $this->hour_init    = substr($item->hour_init, 0, 5);
        $this->hour_finish  = substr($item->hour_finish, 0, 5);
        $this->is_active    = $item->is_active;

        $this->dsSelectSelected('is_active', $item->is_active);

    }

    public function saveItem()
    {      
        $this->validateData();

        $data = (object)[
            'selected_id'   => $this->selected_id,
            'name'          => $this->name,
            'reference'     => $this->reference,
            'hour_init'     => $this->hour_init,
            'hour_finish'   => $this->hour_finish,
            'is_active'     => $this->is_active,
            'update_mode'   => $this->update_mode
        ];
        
        $result = Shift::saveItem($data);
        
        if ($result->type) {

            $mode_saved = $this->update_mode ? 'editado' : 'creado';

            $this->dsToasMessageSuccess($mode_saved);

        } else {

            if ($result->find != '') {

                $this->dsToasMessageWarning($result->find);

            } else {

                $this->dsToasMessageError('Ha ocurrido un error.');
            }

        }

        $this->closeModal();
        
    }

    public function deleteItem($target, $item_id, $item_name)
    {
        
        $content = (Object)[
            'id'        => $item_id,
            'name'      => $item_name,
            'inModule'  => 'el turno'
        ];
        
        $this->dsAlertDeleteItem($target, $content);

    }

    public function disabledItem($id)
    {
    
        $result     = Shift::disabledItem($id);
        
        if ($result->type) {

            $this->dsToasMessageSuccess('eliminado');

        } else {

            if ($result->find != '') {

                $this->dsToasMessageWarning($result->find);

            } else {

                $this->dsToasMessageError('Ha ocurrido un error.');
            }
            
        }

    }

    public function validateRegister()
    {
        $selected_id = ($this->update_mode) ? $this->selected_id : false;

        if ($this->name != '' && $this->reference != '') {

            $validateUniqueRegister = Shift::validateUniqueRegister($this->name, $this->reference, $selected_id);

            if ($validateUniqueRegister) {
                $this->name         = '';
                $this->reference    = '';
                $this->dsToasMessageError('Ya existe un registro con los datos ingresados.');
                
            }

        }
        
        if ($this->hour_init != '' && $this->hour_finish != '') {
            
            $conflictShifts = Shift::getConflictShifts($this->hour_init, $this->hour_finish, $selected_id);
            
            if ($conflictShifts) {
                $this->hour_init    = '';
                $this->hour_finish  = '';
                $this->dsToasMessageError('Existen conflictos con otros turnos.');
                
            }
        }
        
    }

    public function render()
    {

        $key_word           = '%' . $this->key_word . '%';

        $paginate_number    = $this->paginate_number;

        $order_by           = intval($this->order_by);

        $listModule         = Shift::getSelfItems($key_word, $paginate_number, $order_by);
        
        $this->setPage(1);

        return view('livewire.schools.shifts.shifts',[
            'listModule'    => $listModule,
        ]);

    }

}
