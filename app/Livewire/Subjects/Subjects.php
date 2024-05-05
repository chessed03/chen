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

    public $subject_type_id, $degree_reference_id, $career_id, $name, $is_active, $list_degree_references, $list_subject_type, $list_careers;

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

        $this->list_subject_type        = ___getSubjectTypes__();
        
        $this->list_degree_references   = Subject::getDegreeReference();

        $this->list_careers             = Subject::getCareers();

    }

    private function resetFieldsAndHydrate()
    {
        
        $this->selected_id          = null;
        $this->subject_type_id      = null;
        $this->degree_reference_id  = null;
        $this->career_id            = null;
        $this->name                 = null;
        $this->is_active            = null;
        $this->update_mode          = false;

        $this->generateSelectOrMultiselect(true, true, 'career_id', null);
        $this->dsSelectSelected('subject_type_id', null);
        $this->dsSelectSelected('degree_reference_id', null);
        $this->dsSelectSelected('career_id', null);
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

    public function generateSelectOrMultiselect($isDisabled, $isSearchable, $wireModel, $tagComponent)
    {

        $contentComponent = (object)[
            'isDisabled'        => $isDisabled,
            'isSearchable'      => $isSearchable,
            'wireModel'         => $wireModel,
            'tagComponent'      => $tagComponent
        ];

        $contentOnDiv     =  ___csSelectOrMultiselect___($contentComponent);
        $this->dsDivChangeContent('Careers', $contentOnDiv);

    }

    public function subjectTypeSelected($status)
    {
        // ************************************************************************ //
        // **? Se obtiene el tipo de materia seleccionada, para esta sección de ?** //
        // **? los tipos de materias estan en el archivo Helper.php, como refe- ?** //
        // **? rencia los valores:                                              ?** //
        // **!      id: 1 = Currículum fundamental                              !** //             
        // **!      id: 2 = Currículum laboral                                  !** //
        // TODO: Cuando es curriculum fundamental, la materia está disponible - *** //
        // TODO: para un mismo grado, con la opción de varias carreras, en caso *** //
        // TODO: para el curículum laraboral, es únicamente para una carrera en *** //
        // TODO: un mismo grado, las materias son para un solo grado.           *** //
        // ************************************************************************ // 

        $this->dsSelectSelectedDynamic('career_id', null);

        $this->career_id        = null;
        $subjectTypeSelected    = (int) $this->subject_type_id;
        $tagComponent           = ($subjectTypeSelected == 1) ? 'multiple' : '';  
        $this->generateSelectOrMultiselect(false, true, 'career_id', $tagComponent);      
        $this->dsSelectOptionsDynamic('career_id', $this->list_careers);
        
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
