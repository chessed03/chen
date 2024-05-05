<?php

function ___csSelectOrMultiselect___($contentComponent)
{
    $isDisabled = ($contentComponent->isDisabled) ? 'disabled' : '';
    
    $component  = "
        <select {$contentComponent->tagComponent}
            {$isDisabled}
            class='selectpicker mb-1'
            data-live-search='{$contentComponent->isSearchable}'
            data-style='btn-light'
            title='Elige una opción.'
            id='{$contentComponent->wireModel}'
            wire:model.live='{$contentComponent->wireModel}'
        >
        </select>
    ";
    
    return $component;

}
