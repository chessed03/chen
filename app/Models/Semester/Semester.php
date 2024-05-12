<?php

namespace App\Models\Semester;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\School\Degree\Degree;
use App\Models\School\Group\Group;
use App\Models\Career\Career;
use App\Models\School\Shift\Shift;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    protected $casts = [
        'careers' => 'json',
    ];

    const ENABLED    = 1;

    const DISABLED   = 2;

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    
    public static function getSelfItems($key_word, $paginate_number, $order_by, $degree_id, $group_id, $career_id)
    {

        $query = self::query()
            ->where('name', 'LIKE', '%' . $key_word . '%')
            ->where('is_active', self::ENABLED);      

        if ($degree_id) {

            $query->where('degree_id', $degree_id);

        }

        if ($group_id) {

            $query->where('group_id', $group_id);

        }

        if ($career_id) {

            $query->whereJsonContains('careers', $career_id);

        }

        switch ($order_by) {
            case 1:
                $query->orderBy('degree_id', 'ASC');
                break;
            case 2:
                $query->orderBy('degree_id', 'DESC');
                break;
            case 3:
                $query->orderBy('created_at', 'DESC');
                break;
            case 4:
                $query->orderBy('created_at', 'ASC');
                break;
            default:
                $query->orderBy('created_at', 'ASC');
                break;
        }

        return $query->paginate($paginate_number);

    }

    public static function getItemById($id)
    {
        
        $result = null;

        $query  = self::query()
            ->where('id', $id)
            ->first();

        if ($query) {

            $result = $query;

        }

        return $result;

    }

    public static function saveItem($data)
    {
        $result = (object)[
            'type'  => false,
            'bound' => false,
            'find'  => ''
        ];

        $validateItem = self::validateUniqueItem($data);
        
        if (!$validateItem) {

            if ($data->update_mode) {

                $updateItem = self::updateItem($data, $result);
    
                return $updateItem;            
    
            } else {
    
                $createItem = self::createItem($data, $result);
                
                return $createItem;
    
            }

        } else {

            $result->find = "Ya existe un registro con los datos ingresados.";

        }
        
        return $result;

    }

    public static function createItem($data, $result)
    {
        
        $item               = new self();
        $item->degree_id    = $data->degree_id;
        $item->group_id     = $data->group_id;
        $item->careers      = $data->careers;
        $item->name         = $data->name;
        $item->is_active    = self::ENABLED;

        if($item->save()) {

            $result->type = true;

        }       

        return $result;

    }
    
    public static function updateItem($data, $result)
    {

        $item       = self::find($data->selected_id);
        $boundItem  = false;

        if ($data->is_active == self::DISABLED) {
 
            $validateItemRelations  = self::validateItemRelations($item, $result);
            $boundItem              = $validateItemRelations->bound;

        }

        if ($boundItem) {

            $result->find   = $validateItemRelations->find;

        } else {

            $item->degree_id    = $data->degree_id;
            $item->group_id     = $data->group_id;
            $item->careers      = $data->careers;
            $item->name         = $data->name;
            $item->is_active    = $data->is_active;

            if($item->update()) {

                $result->type = true;

            }

        }

        return $result;

    }

    public static function disabledItem($id)
    {
        
        $item   = self::find($id);

        $result = (object)[
            'type'  => false,
            'bound' => false,
            'find'  => ''
        ];

        $validateItemRelations  = self::validateItemRelations($item, $result);

        if ($validateItemRelations->bound) {

        $result->find   = $validateItemRelations->find;

        } else {
            
            $item->is_active    = self::DISABLED; 
            
            if( $item->update() ) {

                $result->type = true;

            }

        }
        
        return $result;

    }

    public static function validateUniqueItem($data)
    {
        $query = self::query()
            ->where('name', $data->name)
            ->where('is_active', self::ENABLED);
        
        if ($data->update_mode) {

            $query->where('id', '!=', $data->selected_id);

        }

        $result = $query->exists();
       
        if ($result) {  

            return true;

        }

        return false;
    }

    public static function validateItemRelations($item, $result)
    {

        //**? De momento en ninguna de las tablas precisa un semester_id
        //**? en cuanto se cree alguna con la relacion con este modelo y
        //**? respectiva llaves FK's, hacer la validación o validaciones 
        //**! Retornamos el valor de $result (valoderes por default)

        return $result;

    }

    public static function validateExistDegree($degree_id)
    {
        $result = false;

        $query = self::query()
            ->where('degree_id', $degree_id)
            ->where('is_active', self::ENABLED)
            ->exists();
            
        if ($query) {

            $result = true;

        }
            
        return $result;
    }

    public static function validateExistGroup($group_id)
    {
        $result = false;

        $query = self::query()
            ->where('group_id', $group_id)
            ->where('is_active', self::ENABLED)
            ->exists();
            
        if ($query) {

            $result = true;

        }
            
        return $result;
    }

    public static function validateExistCareer($career_id)
    {
        
        $result = false;

        $query = self::query()
            ->whereJsonContains('careers', $career_id)
            ->where('is_active', self::ENABLED)
            ->exists();
            
        if ($query) {

            $result = true;

        }
            
        return $result;
        
    }

    public static function validateExistShift($shift_id)
    {
        $result = false;

        $query = self::query()
            ->where('shift_id', $shift_id)
            ->where('is_active', self::ENABLED)
            ->exists();
            
        if ($query) {

            $result = true;

        }
            
        return $result;
    }

    public static function getDegrees()
    {
        
        return Degree::getItems();

    }

    public static function getGroups()
    {
        
        return Group::getItems();

    }

    public static function getCareers()
    {
        return Career::getItems();
    }
    
    public static function getCareersByShiftId($shift_id)
    {
       
        return Career::getCareersByShiftId($shift_id);

    }
}
