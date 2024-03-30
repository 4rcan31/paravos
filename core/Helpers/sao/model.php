<?php


function model(string $module, bool $return = true, string $route = '/app'){
    /* 
        Todos los modelos solo podran hacer consultas a la base de datos sin
        permisos de super usuario (root) esto para mas seguridad, ademas
        que servicios de la nube no permiten que la app desplegada a internet
        utilice credenciales de tipo root, por eso mismo, el ultimo parametro
        es false
    */
    return import('Models/'.$module.".php", $return, $route, false);
}
