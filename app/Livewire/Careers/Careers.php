<?php

namespace App\Livewire\Careers;

use App\Livewire\Traits\DispatchServices;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Career\Career;

class Careers extends Component
{
    
    use DispatchServices;
    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners        = ['disabledItem'];
    
    public $paginate_number     = 5;

    public $order_by            = 3;

    public $action_loader, $headers_table, $modal_title,  $modal_warnings, $modal_target, $key_word, $selected_shift_id, $selected_id, $update_mode;

    public $name, $shifts, $is_active, $list_shifts;

    public function mount()
    {

        $this->action_loader    = "paginate_number, order_by, key_word, selected_shift_id, clearFilters";

        $this->headers_table    = [
            (object)['name' => 'Nombre', 'class' => '', 'width' => '35%'],
            (object)['name' => 'Turno', 'class' => 'text-center', 'width' => '40%'],
            (object)['name' => 'Estado', 'class' => 'text-center', 'width' => '10%'],
            (object)['name' => 'Acciones', 'class' => 'text-right', 'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Los campos marcados con (*) son obligatorios',
        ];

        $this->list_shifts      = Career::getShifts();

    }

    public function validateData()
    {
    
        $rules = [
            'name'      => 'required',
            'shifts'    => 'required',
        ];

        if ($this->update_mode) {

            $rules['is_active'] = 'required';

        }

        $messages = [
            'required' => 'El campo es requerido.',
        ];
    
        $this->validate($rules, $messages);
    }

    private function resetFieldsAndHydrate()
    {
        $this->selected_id  = null;
        $this->name         = null;
        $this->shifts       = null;
        $this->is_active    = null;
        $this->update_mode  = false;

        $this->dsSelectSelected('shifts', null);
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
        
        $item               = Career::getItemById($this->selected_id);
        $this->name         = $item->name;
        $this->shifts       = $item->shifts;
        $this->is_active    = $item->is_active;

        $this->dsSelectSelected('shifts', $item->shifts);
        $this->dsSelectSelected('is_active', $item->is_active);

    }

    public function saveItem()
    {      
        
        $this->validateData();
        
        $data = (object)[
            'selected_id'   => $this->selected_id,
            'name'          => $this->name,
            'shifts'        => $this->shifts,
            'is_active'     => $this->is_active,
            'update_mode'   => $this->update_mode
        ];
      
        $result = Career::saveItem($data);
        
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
            'inModule'  => 'la carrera'
        ];
        
        $this->dsAlertDeleteItem($target, $content);

    }

    public function disabledItem($id)
    {

        $result = Career::disabledItem($id);
        
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

    public function clearFilters()
    {   
        
        $this->selected_shift_id    = null;
        $this->dsSelectSelected('selected_shift_id', null);

    }

    public function render()
    {

        $key_word           = '%' . $this->key_word . '%';

        $paginate_number    = $this->paginate_number;

        $order_by           = intval($this->order_by);

        $shift_id           = $this->selected_shift_id;

        $listModule         = Career::getSelfItems($key_word, $paginate_number, $order_by, $shift_id);
        
        $this->setPage(1);

        return view('livewire.careers.careers',[
            'listModule'    => $listModule,
        ]);

    }

}
