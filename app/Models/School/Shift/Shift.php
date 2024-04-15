<?php

namespace App\Models\School\Shift;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\School\Degree\Degree;
use App\Models\Career\Career;
use Carbon\Carbon;

class Shift extends Model
{
    
    use HasFactory;

    protected $table = 'shifts';

    const ENABLED    = 1;

    const DISABLED   = 2;

    public static function getSelfItems($key_word, $paginate_number, $order_by)
    {

        $query = self::query()
            ->where('name', 'LIKE', '%' . $key_word . '%')
            ->where('is_active', '!=', self::DISABLED);

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
        $item->reference    = $data->reference;
        $item->hour_init    = $data->hour_init;
        $item->hour_finish  = $data->hour_finish;
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
            $item->reference    = $data->reference;
            $item->hour_init    = $data->hour_init;
            $item->hour_finish  = $data->hour_finish;
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

            if($item->update()) {

                $result->type   = true;

            }
            
        }

        return $result;

    }

    public static function validateItemRelations($item, $result) 
    {

        $validateInDegrees  = Degree::validateExistShift($item->id);

        if ($validateInDegrees) {

            $result->bound  = true;
            $result->find   = 'Registro vinculado a un <strong>Grado<strong>.';

        }

        $validateInCareers  = Career::validateExistShift($item->id);
            
        if ($validateInCareers) {

            $result->bound  = true;
            $result->find   = 'Registro vinculado a una <strong>Carrera<strong>.';

        }

        return $result;

    }

    public static function validateUniqueRegister($name, $reference, $selected_id)
    {
       
        $result         = false;

        $validateShift = self::query();

        if ($selected_id) {

            $validateShift->where('id', '!=', $selected_id);

        }

        $validateShift->where('is_active', self::ENABLED)
            ->where(function ($query) use ($name, $reference) {
                $query->where('name', $name)
                    ->orWhere('reference', $reference);
            });

        $validate = $validateShift->exists();

        if ($validate) {

            $result = true;

        }
        
        return $result;
        
    }

    public static function getConflictShifts($new_hour_init, $new_hour_finish, $selected_id)
    {
        
        $result         = false;

        $itemHourInit   = Carbon::createFromFormat('H:i', $new_hour_init)->addMinute()->format('H:i:s');
        $itemHourFinish = Carbon::createFromFormat('H:i', $new_hour_finish)->subMinute()->format('H:i:s');

        $validateShift = self::query();

        if ($selected_id) {

            $validateShift->where('id', '!=', $selected_id);

        }

        $validateShift->where('is_active', self::ENABLED)
            ->where('hour_init', '<', $itemHourFinish)
            ->where('hour_finish', '>', $itemHourInit);
            
        $validate = $validateShift->exists();

        if ($validate) {

            $result = true;

        }
        
        return $result;

    }

}
