<?php


function view($html, $data = [], $route = '', $format = 'php'){
    try {
        print("
        <!--
            Powered by Sao
            GitHub: https://github.com/4rcan31/Sao
        
            Developed by: 4rcane31
        -->    
        ");
        core('Views', false);
        ViewData::setData($data);
        $viewPath = empty($route) ? "Views/$html.$format" : "$route/$html.$format";
        import($viewPath, false);
        return true;
    } catch (Exception $e) {
        print($e->getMessage());
        die;
        return false;
    }
}


function route($route, $print = true){
    return $print ? 
    print(routePublic(trim($route, '/'))) :
    routePublic(trim($route, '/'));
}


function Form(){
    core('Views/Notifier.php', false);
}