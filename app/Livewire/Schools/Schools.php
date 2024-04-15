<?php

namespace App\Livewire\Schools;

use App\Livewire\Traits\DispatchServices;
use App\Models\School\School;
use Livewire\WithPagination;
use Livewire\Component;

class Schools extends Component
{
    use DispatchServices;
    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners        = ['disabledItem'];
    
    public $paginate_number     = 5;

    public $order_by            = 3;

    public $action_loader, $headers_table, $modal_title, $modal_warnings, $modal_target, $key_word, $selected_id, $update_mode;

    public $name, $address, $is_active, $list_shifts, $list_degrees, $list_groups, $list_staff_positions, $list_staff_types;

    public function mount()
    {
        
        $this->action_loader    = "paginate_number, order_by, key_word";

        $this->headers_table    = [
            (object)['name' => 'Nombre', 'class' => '', 'width' => '35%'],
            (object)['name' => 'Dirección', 'class' => '', 'width' => '40%'],
            (object)['name' => 'Estado', 'class' => 'text-center', 'width' => '10%'],
            (object)['name' => 'Acciones', 'class' => 'text-right', 'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Los campos marcados con (*) son obligatorios',
        ];

        $this->list_shifts          = School::getShifts();
        $this->list_degrees         = School::getDegrees();
        $this->list_groups          = School::getGroups();
        $this->list_staff_positions = School::getStaffPositions();;
        $this->list_staff_types     = School::getStaffTypes();

    }

    public function validateData()
    {
    
        $rules = [
            'name'      => 'required',
            'address'   => 'required',
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
        $this->address      = null;
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
        
        $item               = School::getItemById($this->selected_id);
        $this->name         = $item->name;
        $this->address      = $item->address;
        $this->is_active    = $item->is_active;
        
        $this->dsSelectSelected('is_active', $item->is_active);

    }

    public function saveItem()
    {      

        $this->validateData();

        $data = (object)[
            'selected_id'   => $this->selected_id,
            'name'          => $this->name,
            'address'       => $this->address,
            'is_active'     => $this->is_active,
            'update_mode'   => $this->update_mode
        ];
             
        $result = School::saveItem($data);
        
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
            'inModule'  => 'la escuela'
        ];
        
        $this->dsAlertDeleteItem($target, $content);

    }

    public function disabledItem($id)
    {
        
        $result = School::disabledItem($id);
        
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

        $listModule         = School::getSelfItems($key_word, $paginate_number, $order_by);

        $this->setPage(1);

        return view('livewire.schools.schools', [
            'listModule'    => $listModule,
        ]);

    }
}
