<?php

use App\Models\School\Shift\Shift;
use App\Models\Career\Career;

//** Generate custom arrays **/

function ___getMenuSidebar___(){

    $result = (object)[
        (object)[
            'route'         => '#',
            'icon'          => 'la la-institution',
            'name'          => 'Escuela',
            'menu'          => 'school',
            'submenu'       => true,
            'itemsSubmenu'  => (object)[
                (object)[
                    'route' => 'school.index',
                    'name'  => 'Datos',
                    'menu'  => 'school',
                ],
                (object)[
                    'route' => 'school.shift.index',
                    'name'  => 'Turnos',
                    'menu'  => 'shift',
                ],
                (object)[
                    'route' => 'school.degree.index',
                    'name'  => 'Grados',
                    'menu'  => 'degree',
                ],
                (object)[
                    'route' => 'school.group.index',
                    'name'  => 'Grupos',
                    'menu'  => 'group',
                ],
                (object)[
                    'route' => 'school.staff-position.index',
                    'name'  => 'Puestos de personal',
                    'menu'  => 'staff-position',
                ],
                (object)[
                    'route' => 'school.staff-type.index',
                    'name'  => 'Tipos de personal',
                    'menu'  => 'staff-type',
                ],
            ]
        ],
        (object)[
            'route'         => 'career.index',
            'icon'          => 'la la-mortar-board',
            'name'          => 'Carreras',
            'menu'          => 'career',
            'submenu'       => false,
            'itemsSubmenu'  => (object)[]
        ],
        (object)[
            'route'         => 'semester.index',
            'icon'          => 'la la-building',
            'name'          => 'Semestres',
            'menu'          => 'semester',
            'submenu'       => false,
            'itemsSubmenu'  => (object)[]
        ],
        (object)[
            'route'         => 'subject.index',
            'icon'          => 'la la-folder-o',
            'name'          => 'Materias',
            'menu'          => 'subject',
            'submenu'       => false,
            'itemsSubmenu'  => (object)[]
        ],
        (object)[
            'route'         => '#',
            'icon'          => 'la la-user',
            'name'          => 'Personal',
            'menu'          => '#',
            'submenu'       => false,
            'itemsSubmenu'  => (object)[]
        ],
    ];
    
    return collect($result);

}

function ___getIsTeacher___()
{
    $result = (object)[
        (object)[
            'id'    => 2,
            'name'  => 'Sin clase'
        ],
        (object)[
            'id'    => 1,
            'name'  => 'Frente a clase'
        ],
    ];
    
    return collect($result);
}

function ___getPriorities___()
{
    $result = (object)[
        (object)[
            'id'    => 3,
            'name'  => 'Baja'
        ],
        (object)[
            'id'    => 2,
            'name'  => 'Media'
        ],
        (object)[
            'id'    => 1,
            'name'  => 'Alta'
        ],
    ];
    
    return collect($result);
}

function ___getSubjectTypes___()
{
    $result = (object)[
        (object)[
            'id'    => 2,
            'name'  => 'Currículum laboral'
        ],
        (object)[
            'id'    => 1,
            'name'  => 'Currículum fundamental'
        ],
    ];
    
    return collect($result);
}

//** Generate names of custom arrays **/

function ___getItemNames___($items, $itemsCollection)
{
    $result = '';

    $count = count($items);

    foreach ($items as $key => $itemId) {

        $query = $itemsCollection->where('id', $itemId)->first();

        if ($query) {

            $result .= $query->name;

            if ($key < $count - 1) {

                $result .= " - ";
                
            }

        }
    
    }

    return $result;
}

function ___getPrioritiesNames___($priority_id)
{
    $arrayValidate = is_array($priority_id);
    $result = '';

    if ($arrayValidate) {
        $itemsCollection    = ___getPriorities___();
        $result             = ___getItemNames___($priority_id, $itemsCollection);
    }

    return $result;
}

function ___getShiftsNames___($shifts)
{
    $arrayValidate = is_array($shifts);
    $result = '';

    if ($arrayValidate) {
        $itemsCollection    = Shift::find($shifts);
        $result             = ___getItemNames___($shifts, $itemsCollection);
    }

    return $result;
}

function ___getTypeSubjectsNames___($typeSubjects)
{

    $arrayValidate = is_array($typeSubjects);
    $result = '';

    if ($arrayValidate) {
        $itemsCollection    = ___getSubjectTypes___();
        $result             = ___getItemNames___($typeSubjects, $itemsCollection);
    }

    return $result;

}

function ___getCareersNames___($careers)
{

    $arrayValidate = is_array($careers);
    $result = '';

    if ($arrayValidate) {
        $itemsCollection    = Career::find($careers);
        $result             = ___getItemNames___($careers, $itemsCollection);
    }

    return $result;

}