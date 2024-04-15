<?php

namespace App\Livewire\Schools\StaffPositions;

use App\Models\School\StaffPosition\StaffPosition;
use App\Livewire\Traits\DispatchServices;
use Livewire\WithPagination;
use Livewire\Component;

class StaffPositions extends Component
{

    use DispatchServices;
    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners        = ['disabledItem'];
    
    public $paginate_number     = 5;

    public $order_by            = 3;

    public $action_loader, $headers_table, $modal_title, $modal_warnings, $modal_target, $key_word, $selected_id, $update_mode;

    public $name, $is_teacher, $is_active, $list_is_teachers;

    public function mount()
    {
        
        $this->action_loader    = "paginate_number, order_by, key_word";

        $this->headers_table    = [
            (object)['name' => 'Nombre', 'class' => '', 'width' => '40%'],
            (object)['name' => 'Tipo de puesto', 'class' => 'text-center', 'width' => '35%'],
            (object)['name' => 'Estado', 'class' => 'text-center', 'width' => '10%'],
            (object)['name' => 'Acciones', 'class' => 'text-right', 'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Los campos marcados con (*) son obligatorios',
        ];

        $this->list_is_teachers = ___getIsTeacher___();

    }

    public function validateData()
    {
    
        $rules = [
            'name'          => 'required',
            'is_teacher'    => 'required',
        ];

        if ($this->update_mode) {

            $rules['is_active'] = 'required';

        }

        $messages = [
            'required'  => 'El campo es requerido.',
        ];
    
        $this->validate($rules, $messages);

    }

    private function resetFieldsAndHydrate()
    {
        $this->selected_id  = null;
        $this->name         = null;
        $this->is_teacher   = null;
        $this->is_active    = null;
        $this->update_mode  = false;

        $this->dsSelectSelected('is_teacher', null);
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
        
        $item               = StaffPosition::getItemById($this->selected_id);
        $this->name         = $item->name;
        $this->is_teacher   = $item->is_teacher;
        $this->is_active    = $item->is_active;

        $this->dsSelectSelected('is_teacher', $item->is_teacher);
        $this->dsSelectSelected('is_active', $item->is_active);

    }

    public function saveItem()
    {      

        $this->validateData();

        $data = (object)[
            'selected_id'   => $this->selected_id,
            'name'          => $this->name,
            'is_teacher'    => $this->is_teacher,
            'is_active'     => $this->is_active,
            'update_mode'   => $this->update_mode
        ];
             
        $result = StaffPosition::saveItem($data);
        
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
            'inModule'  => 'el grado'
        ];
        
        $this->dsAlertDeleteItem($target, $content);

    }

    public function disabledItem($id)
    {
        
        $result = StaffPosition::disabledItem($id);
        
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

    public function render()
    {

        $key_word           = '%' . $this->key_word . '%';

        $paginate_number    = $this->paginate_number;

        $order_by           = intval($this->order_by);

        $listModule         = StaffPosition::getSelfItems($key_word, $paginate_number, $order_by);

        $this->setPage(1);

        return view('livewire.schools.staff-positions.staff-positions', [
            'listModule'    => $listModule,
        ]);

    }

}
