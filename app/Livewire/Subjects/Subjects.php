<?php

namespace App\Livewire\Subjects;

use App\Livewire\Traits\DispatchServices;
use App\Models\Subject\Subject;
use Livewire\WithPagination;
use Livewire\Component;

class Subjects extends Component
{

    use DispatchServices;
    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    protected $listeners        = ['disabledItem'];
    
    public $paginate_number     = 5;

    public $order_by            = 3;

    public $courses             = [];

    public $action_loader, $headers_table, $modal_title,  $modal_warnings, $modal_target, $key_word, $selected_id, $update_mode;

    public $name, $is_active, $list_degrees, $list_careers;

    public function mount()
    {

        $this->action_loader    = "paginate_number, order_by, key_word";

        $this->headers_table    = [
            (object)['name' => 'Nombre', 'class' => '', 'width' => '35%'],
            (object)['name' => 'Cursos', 'class' => '', 'width' => '40%'],
            (object)['name' => 'Estado', 'class' => 'text-center', 'width' => '10%'],
            (object)['name' => 'Acciones', 'class' => 'text-right', 'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Los campos marcados con (*) son obligatorios',
        ]; 
        
        $this->list_degrees   = Subject::getDegrees();

        $this->list_careers   = Subject::getCareers();

    }

    public function prepareCourses($degree_id, $career_id)
    {
            
        $this->courses[] = (object)[
            'degree_id' => $degree_id,
            'career_id' => $career_id,
        ];

        $this->dsInitSelect();

    }

    public function addRow($index)
    {
        $this->resetValidation();

        $degreeId = $this->courses[$index]->degree_id;
        $careerId = $this->courses[$index]->career_id;
        $result = (object)[
            'type' => true,
            'error' => 0,
        ];

        if ($degreeId == "") {

            $result->type   = false;
            $result->error  = 1;
            
        }
        if ($careerId == "") {
            
            $result->type   = false;
            $result->error  = 2;

        }

        if ($degreeId != "" && $careerId != "") {

            foreach ($this->courses as $key => $row) {

                if ($key != $index) {

                    if ($row->degree_id == $degreeId && $row->career_id == $careerId) {
                    
                        $result->type   = false;
                        $result->error  = 3;
                        break;

                    }

                }

            }

        }

        if ($result->type) {
            
            $this->prepareCourses(null, null);

        } else {
            
            switch ($result->error) {

                case 1:

                    $this->addError("courses.{$index}.degree_id", 'El grado no debe estar vacío.');
                    break;

                case 2:

                    $this->addError("courses.{$index}.career_id", 'La carrera no debe estar vacía.');
                    break;

                case 3:

                    $this->addError("courses.{$index}.career_id", 'Ya existe un registro con los datos ingresados.');
                    break;

                case 4:

                    $this->addError("courses.{$index}.degree_id", 'Los campos no deben estar vacíos.');
                    $this->addError("courses.{$index}.career_id", 'Los campos no deben estar vacíos.');
                    break;

            }

        }
    }


    public function deleteRow($index)
    {
        
        $this->resetValidation();

        unset($this->courses[$index]);

    }

    public function validateData()
    {
    
        $rules = [
            'name'  => 'required',
        ];

        foreach ($this->courses as $key => $course) {
            
            if ($course->degree_id == '') {

                $rules["courses.{$key}.degree_id"]  = 'required';

            }

            if ($course->career_id == '') {

                $rules["courses.{$key}.career_id"]  = 'required';

            }
        }

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
        $this->courses      = [];
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

        if (empty($this->courses)) {

            $this->prepareCourses(null, null);

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
        
        $item               = Subject::getItemById($this->selected_id);
        $this->name         = $item->name;

        foreach ($item->courses as $key => $course) {

            $degree_value   = $course["degree_id"];
            $career_value   = $course["career_id"];
            $degree_id      = "courses_{$key}_degree_id";
            $career_id      = "courses_{$key}_career_id";

            $this->prepareCourses($degree_value, $career_value);
            $this->dsSelectSelected($degree_id, $degree_value);
            $this->dsSelectSelected($career_id, $career_value);

        }
        
        $this->is_active    = $item->is_active;
        $this->dsSelectSelected('is_active', $item->is_active);

    }
    /**
     * validar con maestros si estan en un semestre ejemplo 1ro D
     */
    public function saveItem()
    {      

        $this->validateData();

        $data = (object)[
            'selected_id'   => $this->selected_id,
            'name'          => $this->name,
            'courses'       => $this->courses,
            'is_active'     => $this->is_active,
            'update_mode'   => $this->update_mode
        ];
        
        $result = Subject::saveItem($data);
        
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
            'inModule'  => 'la materia'
        ];
        
        $this->dsAlertDeleteItem($target, $content);

    }

    public function disabledItem($id)
    {
        
        $result = Subject::disabledItem($id);
        
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

        $listModule         = Subject::getSelfItems($key_word, $paginate_number, $order_by);

        $this->setPage(1);

        return view('livewire.subjects.subjects', [
            'listModule'    => $listModule,
        ]);
    }
}
