<?php
/* Se encarga de cargar los archivos de la clase. Para utilizarlo en un archivo, lo llamamos con use + namespace de la clase */
    /* Obtiene el nombre de la clase que se solicita */
    spl_autoload_register(function($clase){
        /* Concatenar el archivo de la clase que se solicita */
        /* __DIR__ obtiene el directorio del archivo desde el que se llama (el index en el caso actual) */
        
        $archivo = __DIR__."/".$clase.".php";
        /* Reemplaza las contra barras por barras por si el servidor da problemas con ellas */
        $archivo = str_replace("\\", "/", $archivo);
        
        /* Si existe el archivo de la clase, lo incluye */
        if(is_file($archivo)){
            require_once $archivo;
        }
    });