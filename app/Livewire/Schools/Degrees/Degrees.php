<?php

namespace App\Livewire\Schools\Degrees;

use App\Livewire\Traits\DispatchServices;
use App\Models\School\Degree\Degree;
use Livewire\WithPagination;
use Livewire\Component;

class Degrees extends Component
{

    use DispatchServices;
    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners        = ['disabledItem'];
    
    public $paginate_number     = 5;

    public $order_by            = 3;

    public $action_loader, $headers_table, $modal_title, $modal_warnings, $modal_target, $key_word, $selected_shift_id, $selected_id, $update_mode;

    public $name, $degree_reference_id, $shift_id, $is_active, $selected_period, $list_degree_references, $list_shifts;

    public function mount()
    {
        
        $this->action_loader            = "paginate_number, order_by, key_word, selected_shift_id, clearFilters";

        $this->headers_table            = [
            (object)['name' => 'Nombre', 'class' => '', 'width' => '25%'],
            (object)['name' => 'Referencia', 'class' => 'text-center', 'width' => '10%'],
            (object)['name' => 'Período', 'class' => 'text-center', 'width' => '15%'],
            (object)['name' => 'Turno', 'class' => 'text-center', 'width' => '25%'],
            (object)['name' => 'Estado', 'class' => 'text-center', 'width' => '10%'],
            (object)['name' => 'Acciones', 'class' => 'text-right', 'width' => '15%']
        ];

        $this->modal_warnings           = [
            'Los campos marcados con (*) son obligatorios',
            'El campo nombre se genera en automático al seleccionar [ "Referencia", "Turno"]',
            'El periodo [ 1 ], pertencen las referencias [1, 3, 5]',
            'El periodo [ 2 ], pertencen las referencias [2, 4, 6]',
            'El nombre del grado se genera en automático',
        ];

        $this->list_degree_references   = Degree::getDegreeReferences();
        $this->list_shifts              = Degree::getShifts();

    }

    public function validateData()
    {
    
        $rules = [
            'degree_reference_id'   => 'required',
            'shift_id'              => 'required',
            'name'                  => 'required',
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
        $this->selected_id          = null;
        $this->degree_reference_id  = null;
        $this->shift_id             = null;
        $this->name                 = null;
        $this->is_active            = null;
        $this->update_mode          = false;
        $this->selected_period      = null;

        $this->dsSelectSelected('degree_reference_id', null);
        $this->dsSelectSelected('shift_id', null);
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
        
        $item                       = Degree::getItemById($this->selected_id);
        $this->degree_reference_id  = $item->degree_reference_id;
        $this->shift_id             = $item->shift_id;
        $this->name                 = $item->name;
        $this->is_active            = $item->is_active;

        $this->dsSelectSelected('degree_reference_id', $item->degree_reference_id);
        $this->dsSelectSelected('shift_id', $item->shift_id);
        $this->dsSelectSelected('is_active', $item->is_active);
        $this->generateName();

    }

    public function saveItem()
    {

        $this->validateData();

        $data = (object)[
            'selected_id'           => $this->selected_id,
            'degree_reference_id'   => $this->degree_reference_id,
            'shift_id'              => $this->shift_id,
            'name'                  => $this->name,
            'is_active'             => $this->is_active,
            'update_mode'           => $this->update_mode
        ];
             
        $result = Degree::saveItem($data);
        
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
        
        $result = Degree::disabledItem($id);
        
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

    public function generateName()
    {

        $degree                 = $this->list_degree_references->find($this->degree_reference_id);
        $shift                  = $this->list_shifts->find($this->shift_id);
        $this->reference_degree = $degree ? $degree->reference : '';
        $this->selected_period  = $degree ? $degree->period : '';
        $this->reference_shift  = $shift ? $shift->reference : '';
        $this->name             = $this->reference_degree . $this->reference_shift;
   
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

        $listModule         = Degree::getSelfItems($key_word, $paginate_number, $order_by, $shift_id);

        $this->setPage(1);

        return view('livewire.schools.degrees.degrees', [
            'listModule'    => $listModule,
        ]);

    }

}
