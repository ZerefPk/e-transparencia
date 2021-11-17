<?php

function alertSuccess($component, $message,$title=false ){
    if(!$title){
        $title = "Sucesso!";
    }
    $component->dispatchBrowserEvent('sucess-toast', ['message'=> $message, 'title'=> $title]);
}
function alertInfo($component, $message,$title=false){
    if(!$title){
        $title = "Informação!";
    }
    $component->dispatchBrowserEvent('info-toast', ['message'=> $message, 'title'=> $title]);
}
function alertWarning($component, $message,$title=false){
    if(!$title){
        $title = "Alerta!";
    }
    $component->dispatchBrowserEvent('warning-toast', ['message'=> $message, 'title'=> $title]);
}
function alertError($component, $message,$title=false){
    if(!$title){
        $title = "Error";
    }
    $component->dispatchBrowserEvent('error-toast', ['message'=> $message, 'title'=> $title]);
}
