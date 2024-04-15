<?php

namespace App\Models\School\Degree;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeReference extends Model
{
    use HasFactory;

    protected $table = 'degree_references';

    const ENABLED    = 1;

    const DISABLED   = 2;

    public static function getItems()
    {

        $query = self::query()
            ->where('is_active', self::ENABLED)
            ->get();
        
        return $query;
        
    }

}
