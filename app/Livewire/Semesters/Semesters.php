<?php

namespace App\Livewire\Semesters;

use App\Livewire\Traits\DispatchServices;
use App\Models\Semester\Semester;
use Livewire\WithPagination;
use Livewire\Component;

class Semesters extends Component
{

    use DispatchServices;
    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners        = ['disabledItem'];
    //**! Variables to needs into component **************    
    public $paginate_number     = 5;

    public $order_by            = 3;

    public $action_loader, $headers_table, $modal_title,  $modal_warnings, $modal_target, $key_word, $selected_id, $update_mode;
    //**? Variables to needs into table model ************
    public $degree_id, $group_id, $careers, $name, $is_active;
    //*** Variables to custom into component *************
    public $list_degrees, $list_groups, $list_careers, $selected_degree_id, $selected_group_id, $selected_career_id, $careers_by_degree_id;

    public function mount()
    {

        $this->action_loader    = "paginate_number, order_by, key_word, selected_degree_id, selected_group_id, selected_career_id, clearFilters";

        $this->headers_table    = [
            (object)['name' => 'Nombre', 'class' => '', 'width' => '20%'],
            (object)['name' => 'Grado', 'class' => '', 'width' => '10%'],
            (object)['name' => 'Grupo', 'class' => 'text-center', 'width' => '15%'],
            (object)['name' => 'Carreras', 'class' => '', 'width' => '25%'],
            (object)['name' => 'Estado', 'class' => 'text-center', 'width' => '15%'],
            (object)['name' => 'Acciones', 'class' => 'text-right', 'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Revise sus datos antes de crear un nuevo semestre',
            'Los campos marcados con (*) son obligatorios',
            'Cada semestre creado es único',
            'El nombre del semestre se genera en automático',
        ];

        $this->list_degrees = Semester::getDegrees();
        $this->list_groups  = Semester::getGroups();
        $this->list_careers = Semester::getCareers();
        $this->careers      = [];

    }

    public function validateData()
    {
    
        $rules = [
            'degree_id' => 'required',
            'group_id'  => 'required',
            'careers'   => 'required',
            'name'      => 'required'
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
        $this->degree_id            = null;
        $this->group_id             = null;
        $this->careers              = null;
        $this->name                 = null;
        $this->is_active            = null;
        $this->update_mode          = false;

        $this->dsSelectSelectedDynamic('careers', null);
        $this->dsSelectOptionsDynamic('careers', null);
        $this->dsSelectSelected('degree_id', null);
        $this->dsSelectSelected('group_id', null);
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
        
        $item               = Semester::getItemById($this->selected_id);
        
        $this->degree_id    = $item->degree_id;
        $this->group_id     = $item->group_id;
        $this->careers      = $item->careers;
        $this->name         = $item->name;
        $this->is_active    = $item->is_active;
        
        $this->dsSelectSelected('degree_id', $item->degree_id);
        $this->degreeSelected(false);
        $this->dsSelectSelectedDynamic('careers', $item->careers);
        $this->dsSelectSelected('group_id', $item->group_id);
        $this->dsSelectSelected('is_active', $item->is_active);
       

    }

    public function saveItem()
    {   
        $this->validateData();

        $data = (object)[
            'selected_id'   => $this->selected_id,
            'degree_id'     => $this->degree_id,
            'group_id'      => $this->group_id,
            'careers'       => $this->careers,
            'name'          => $this->name,
            'is_active'     => $this->is_active,
            'update_mode'   => $this->update_mode
        ];
        
        $result = Semester::saveItem($data);
        
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
            'inModule'  => 'el semestre'
        ];
        
        $this->dsAlertDeleteItem($target, $content);

    }

    public function disabledItem($id)
    {
        
        $result = Semester::disabledItem($id);
        
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

    public function degreeSelected($status)
    {
        
        //**! No se usa ($this->careers) o mas bien, alguna variable livewire, ya que al ser un select !**//
        //**! no necesita alguna variable de este tipo, lo que está realizando es llevar la lista de - !**//
        //**! carreras con JS (Pasando el array a traves de una función en JS) de manera dinámica.     !**//

        $degree     = $this->list_degrees->find($this->degree_id);
        $careers    = Semester::getCareersByShiftId($degree->shift_id);
        $this->dsSelectOptionsDynamic('careers', $careers);

        if ($status) {
            $this->generateName();
        }
        
    }

    public function generateName()
    {

        $degree         = $this->list_degrees->find($this->degree_id);
        $group          = $this->list_groups->find($this->group_id); 
        $degree_name    = $degree ? $degree->name : '';
        $group_name     = $group ? $group->name : '';
        $this->name     = "{$degree_name}{$group_name}";
   
    }

    public function clearFilters()
    {   

        $this->selected_degree_id   = null;
        $this->selected_group_id    = null;
        $this->selected_career_id   = null;
        $this->dsSelectSelected('selected_degree_id', null);
        $this->dsSelectSelected('selected_group_id', null);
        $this->dsSelectSelected('selected_career_id', null);

    }

    public function render()
    {
        
        $key_word           = '%' . $this->key_word . '%';

        $paginate_number    = $this->paginate_number;

        $order_by           = intval($this->order_by);

        $degree_id          = $this->selected_degree_id;

        $group_id           = $this->selected_group_id;

        $career_id          = $this->selected_career_id;

        $listModule         = Semester::getSelfItems($key_word, $paginate_number, $order_by, $degree_id, $group_id, $career_id);
        
        $this->setPage(1);

        return view('livewire.semesters.semesters', [
            'listModule'    => $listModule,
        ]);

    }
    
}
