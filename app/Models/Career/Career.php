<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Semester\Semester;
use App\Models\School\Shift\Shift;

class Career extends Model
{
    use HasFactory;

    protected $table = 'careers';

    protected $casts = [
        'shifts' => 'json',
    ];

    const ENABLED    = 1;

    const DISABLED   = 2;

    public static function getSelfItems($key_word, $paginate_number, $order_by, $shift_id)
    {

        $query = self::query()
            ->where('name', 'LIKE', '%' . $key_word . '%')
            ->where('is_active', '!=', self::DISABLED);

        if ($shift_id) {

            $query->whereJsonContains('shifts', $shift_id);
            
        }

        switch ($order_by) {
            case 1:
                $query->orderBy('name', 'ASC');
                break;
            case 2:
                $query->orderBy('name', 'DESC');
                break;
            case 3:
                $query->orderBy('created_at', 'DESC');
                break;
            case 4:
                $query->orderBy('created_at', 'ASC');
                break;
            default:
                $query->orderBy('name', 'ASC');
                break;
        }

        return $query->paginate($paginate_number);

    }

    public static function getItems()
    {
        
        $query = self::query()
            ->where('is_active', self::ENABLED)
            ->get();

        return $query;
        
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

        
        if ($data->update_mode) {

            $updateItem = self::updateItem($data, $result);

            return $updateItem;            

        } else {

            $createItem = self::createItem($data, $result);
            
            return $createItem;

        }
        
        return $result;

    }

    public static function createItem($data, $result)
    {
        
        $item               = new self();
        $item->name         = $data->name;
        $item->shifts       = $data->shifts;
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

            $item->name         = $data->name;
            $item->shifts       = $data->shifts;
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

    public static function validateItemRelations($item, $result) 
    {

        $validateInSemesters  = Semester::validateExistCareer($item->id);
            
        if ($validateInSemesters) {

            $result->bound  = true;
            $result->find   = 'Registro vinculado a un <strong>Semestre<strong>.';

        }

        $validateInSubjects  = Subject::validateExistCareer($item->id);
            
        if ($validateInSubjects) {

            $result->bound  = true;
            $result->find   = 'Registro vinculado en una <strong>Materia<strong>.';

        }

        return $result;

    }

    public static function validateExistShift($shift_id)
    {
        
        $result = false;

        $query = self::query()
            ->whereJsonContains('shifts', (string) $shift_id)
            ->where('is_active', self::ENABLED)
            ->exists();
            
        if ($query) {

            $result = true;

        }
            
        return $result;

    }

    public static function getShifts()
    {

        return Shift::getItems();

    }

    public static function getCareersByShiftId($shift_id)
    {
        $query = self::query()
            ->whereJsonContains('shifts', (string) $shift_id)
            ->where('is_active', self::ENABLED)
            ->get();

        return $query;
    }

}
