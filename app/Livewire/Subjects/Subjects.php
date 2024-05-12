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
    //**! Variables to needs into component **************
    public $paginate_number     = 5;

    public $order_by            = 3;
    
    public $action_loader, $headers_table, $modal_title,  $modal_warnings, $modal_target, $key_word, $selected_id, $update_mode;
    //**? Variables to needs into table model ************
    public $subject_type_id, $degree_reference_id, $careers, $name, $is_active;
    //*** Variables to custom into component *************
    public  $list_degree_references, $list_subject_types, $list_careers, $temp_careers, $temp_career, $is_multiselect, $selected_subject_type_id, $selected_degree_reference_id, $selected_career_id;

    public function mount()
    {

        $this->action_loader    = "paginate_number, order_by, key_word, selected_subject_type_id, selected_degree_reference_id, selected_career_id, clearFilters";

        $this->headers_table    = [
            (object)['name' => 'Nombre', 'class' => '', 'width' => '20%'],
            (object)['name' => 'Tipo de materia', 'class' => 'text-center', 'width' => '20%'],
            (object)['name' => 'Referencia de grado', 'class' => 'text-center', 'width' => '15%'],
            (object)['name' => 'Carreras', 'class' => 'text-center', 'width' => '15%'],
            (object)['name' => 'Estado', 'class' => 'text-center', 'width' => '15%'],
            (object)['name' => 'Acciones', 'class' => 'text-right', 'width' => '15%']
        ];

        $this->modal_warnings   = [
            'Los campos marcados con (*) son obligatorios',
        ]; 

        $this->list_subject_types       = ___getSubjectTypes___();
        
        $this->list_degree_references   = Subject::getDegreeReference();

        $this->list_careers             = Subject::getCareers();

    }

    public function validateData()
    {
    
        $rules = [
            'degree_reference_id'   => 'required',
            'subject_type_id'       => 'required',
            'name'                  => 'required',
            'temp_careers'          => ($this->is_multiselect) ? 'required' : '',
            'temp_career'           => (!$this->is_multiselect) ? 'required' : '',
            'is_active'             => ($this->update_mode) ? 'required' : ''
        ];

        $messages = [
            'required' => 'El campo es requerido.',
        ];  

        $this->validate($rules, $messages);
    }

    private function resetFieldsAndHydrate()
    {
        
        $this->selected_id          = null;
        $this->subject_type_id      = null;
        $this->degree_reference_id  = null;
        $this->temp_careers         = null;
        $this->temp_career          = null;
        $this->name                 = null;
        $this->is_active            = null;
        $this->update_mode          = false;

        $this->dsSelectSelected('subject_type_id', null);
        $this->dsSelectSelected('degree_reference_id', null);
        $this->dsSelectSelected('temp_careers', null);
        $this->dsSelectSelected('temp_career', null);
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
        
        $item                       = Subject::getItemById($this->selected_id);
        $this->subject_type_id      = $item->subject_type_id;
        $this->degree_reference_id  = $item->degree_reference_id;
        if (count($item->careers) > 1) {
            $this->temp_careers = $item->careers;
        } else {
            $this->temp_career  = $item->careers;
        }
        $this->name                 = $item->name;        
        $this->is_active            = $item->is_active;
        
        $this->dsSelectSelected('subject_type_id', $this->subject_type_id);
        $this->dsSelectSelected('degree_reference_id', $this->degree_reference_id);
        $this->dsSelectSelected('temp_careers', $this->temp_careers);
        $this->dsSelectSelected('temp_career', $this->temp_career);
        $this->dsSelectSelected('is_active', $item->is_active);
        $this->subjectTypeSelected(false);
        
    }
   
    public function saveItem()
    {      

        $this->validateData();

        $data = (object)[
            'selected_id'           => $this->selected_id,
            'subject_type_id'       => $this->subject_type_id,
            'degree_reference_id'   => $this->degree_reference_id,
            'careers'               => ($this->is_multiselect) ? $this->temp_careers : [$this->temp_career],
            'name'                  => $this->name,
            'is_active'             => $this->is_active,
            'update_mode'           => $this->update_mode
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

        if ($status) {
            $this->careers      = null;
            $this->temp_careers = null;
            $this->temp_career  = null;
        }
        
        $this->is_multiselect   = (((int) $this->subject_type_id) == 1) ? true : false;
        
    }

    public function clearFilters()
    {   
        
        $this->selected_subject_type_id     = null;
        $this->selected_degree_reference_id = null;
        $this->selected_career_id           = null;
        $this->dsSelectSelected('selected_subject_type_id', null);
        $this->dsSelectSelected('selected_degree_reference_id', null);
        $this->dsSelectSelected('selected_career_id', null);

    }
    
    public function render()
    {
        $key_word               = '%' . $this->key_word . '%';

        $paginate_number        = $this->paginate_number;

        $order_by               = intval($this->order_by);

        $subject_type_id        = $this->selected_subject_type_id;

        $degree_reference_id    = $this->selected_degree_reference_id;

        $career_id              = $this->selected_career_id;

        $listModule             = Subject::getSelfItems($key_word, $paginate_number, $order_by, $subject_type_id, $degree_reference_id, $career_id);

        $this->setPage(1);

        return view('livewire.subjects.subjects', [
            'listModule'    => $listModule,
        ]);
    }
}
