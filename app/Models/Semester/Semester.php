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

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public static function getSelfItems($key_word, $paginate_number, $order_by)
    {

        $query = self::query()
            ->where('is_active', self::ENABLED);
            // ->where(function ($query) use ($key_word) {
            //     $query->where('degree_id', 'LIKE', '%' . $key_word . '%')
            //         ->orWhereHas('degree', function ($query) use ($key_word) {
            //             $query->where('name', 'LIKE', '%' . $key_word . '%');
            //         })
            //         ->orWhereHas('group', function ($query) use ($key_word) {
            //             $query->where('name', 'LIKE', '%' . $key_word . '%');
            //         })
            //         ->orWhereHas('shift', function ($query) use ($key_word) {
            //             $query->where('name', 'LIKE', '%' . $key_word . '%');
            //         })
            //         ->orWhereHas('career', function ($query) use ($key_word) {
            //             $query->where('name', 'LIKE', '%' . $key_word . '%');
            //         });
            // });
        
       

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
        $item->shift_id     = $data->shift_id;
        $item->career_id    = $data->career_id;
        $item->is_active    = self::ENABLED;

        if($item->save()) {

            $result->type = true;

        }       

        return $result;

    }
    /**
     * validar con maestros si estan en un semestre ejemplo 1ro D
     */
    public static function updateItem($data, $result)
    {

        $item       = self::find($data->selected_id);
        $boundItem  = false;

        // if ($data->is_active == self::DISABLED) {
 
        //     $validateItemRelations  = self::validateItemRelations($item, $result);
        //     $boundItem              = $validateItemRelations->bound;

        // }

        // if ($boundItem) {

        //     $result->find   = $validateItemRelations->find;

        // } else {

            $item->degree_id    = $data->degree_id;
            $item->group_id     = $data->group_id;
            $item->shift_id     = $data->shift_id;
            $item->career_id    = $data->career_id;
            $item->is_active    = $data->is_active;

            if($item->update()) {

                $result->type = true;

            }

        // }

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

        // $validateItemRelations  = self::validateItemRelations($item, $result);

        // if ($validateItemRelations->bound) {

            // $result->find   = $validateItemRelations->find;

        // } else {
            
            $item->is_active    = self::DISABLED; 
            
            if( $item->update() ) {

                $result->type = true;

            }

        // }
        
        return $result;

    }

    public static function validateUniqueItem($data)
    {
        $query = self::query()
            ->where('degree_id', $data->degree_id)
            ->where('group_id', $data->group_id)
            ->where('shift_id', $data->shift_id)
            ->where('career_id', $data->career_id)
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

    // public static function validateItemRelations($item, $result) 
    // {

    //     $validateInSubjects  = Subject::validateExistSemester($item->id);
            
    //     if ($validateInSubjects) {

    //         $result->bound  = true;
    //         $result->find   = 'Registro vinculado a un <strong>Semestre<strong>.';

    //     }

    //     return $result;

    // }

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
            ->where('career_id', $career_id)
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

    public static function getShifts()
    {

        return Shift::getItems();

    }

    public static function getCareersByShiftId($shift_id)
    {
       
        return Career::getCareersByShiftId($shift_id);

    }
}
