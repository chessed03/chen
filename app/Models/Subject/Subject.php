<?php

namespace App\Models\Subject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\School\Degree\DegreeReference;
use Illuminate\Database\Eloquent\Model;
use App\Models\School\Degree\Degree;
use App\Models\Career\Career;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $casts = [
        'courses' => 'json',
    ];

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
        $item->courses      = $data->courses;
        $item->is_active    = self::ENABLED;

        if( $item->save() ) {

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
            $item->courses      = $data->courses;
            $item->is_active    = $data->is_active;
    
            if($item->update()) {
    
                $result->type   = true;
    
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

    public static function validateExistCareer($career_id)
    {
        
        $result = false;

        $query = self::query()
            ->where('career_id', $group_id)
            ->where('is_active', self::ENABLED)
            ->exists();
            
        if ($query) {

            $result = true;

        }
            
        return $result;

    }

    public static function getDegreeReference()
    {
        return DegreeReference::getItems();
    }

    public static function getCareers()
    {
        return Career::getItems();
    }
}
