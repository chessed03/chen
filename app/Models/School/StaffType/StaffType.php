<?php

namespace App\Models\School\StaffType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffType extends Model
{
    
    use HasFactory;

    protected $table = 'staff_types';

    const ENABLED           = 1;

    const DISABLED          = 2;

    const PRIORITY_HIGH     = 1;

    const PRIORITY_MEDIUM   = 2;

    const PRIORITY_LOW      = 3;

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
        $item->priority_id  = $data->priority_id;
        $item->name         = $data->name;
        $item->is_active    = self::ENABLED;

        if( $item->save() ) {

            $result->type = true;

        }

        return $result;

    }

    public static function updateItem($data, $result)
    {
        $item               = self::find($data->selected_id);                

        $item->priority_id  = $data->priority_id;
        $item->name         = $data->name;
        $item->is_active    = $data->is_active;

        if($item->update()) {

            $result->type   = true;

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
        
        $item->is_active    = self::DISABLED;

        if($item->update()) {

            $result->type   = true;

        }
       
        return $result;

    }

}
