<?php

use App\Models\School\Shift\Shift;

function __getMenuSidebar__(){

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

function ___getPriorities__()
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

function ___getSubjectTypes__()
{
    $result = (object)[
        (object)[
            'id'    => 2,
            'name'  => 'Currículum Laboral'
        ],
        (object)[
            'id'    => 1,
            'name'  => 'Currículum Fundamental'
        ],
    ];
    
    return collect($result);
}

function ___getPrioritiesNames__($priority_id)
{
    $arrayValidate = is_array($priority_id);
    $result = '';

    if ($arrayValidate) {
        $itemsCollection    = ___getPriorities__();
        $result             = ___getItemNames___($priority_id, $itemsCollection);
    }

    return $result;
}

function ___getShiftsNames__($shifts)
{
    $arrayValidate = is_array($shifts);
    $result = '';

    if ($arrayValidate) {
        $itemsCollection    = Shift::find($shifts);
        $result             = ___getItemNames___($shifts, $itemsCollection);
    }

    return $result;
}

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