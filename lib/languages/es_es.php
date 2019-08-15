<?php

//Implements the core multilanguage functionality


class base_language {
    var $lang=array(
        
        //Helpers Implementation
        
        "of" => "de",
        "add" => "Nuevo",
        "edit" => "Editar",
        "delete" => "Borrar",       
        "save" => "Guardar",       
        //"operations" => "Operaciones",
        "yes" => "Si",
        "no" => "No",
        "back" => "Atras",
        "cancel" => "Cancelar",
        "deleteConfirmation" => "Desea eliminar el registro ?",
        "okOperationTrue" => "Operaci&oacute;n Satisfactoria.",
        "okOperationFalse" => "Hubo un Error en la Operaci&oacute;n.",
        
        //Validation
        
        "required" => " es requerido ",
        "fieldValidation" => " debe ser ",
        "numericTypeValidation" => "numerico",
        "dateTypeValidation" => "una fecha valida: A-M-D",
        
        //Data Base
        
        "uniqueError" => "Se ha impedido generar datos duplicados para el campo: ",
        
        //BPM
        "editBpm" => "Editar Flujo del Proceso",       
        "bpmState" => "Estado del Proceso",
        "availableActionsFor" => "Acciones disponibles para:",
        "registeringAction" => "Aplicar Acci&oacute;n:",
        
    );
}