<?php


class Validate{
    public $datos = [];
    public $validates = [];
    public $msg = [];

    function __construct($datos){
        $this->datos = $datos;    
    }

    public function rule($rule, array $fields, mixed $otros = null){
        if($rule === 'required'){
            array_push($this->validates, $this->required($fields));
        }else if($rule === 'contain'){
            array_push($this->validates, $this->contain($fields, $otros));
        }else if($rule == 'email'){
            array_push($this->validates, $this->email($fields));
        }else if($rule == 'is'){
            array_push($this->validates, $this->is($fields, $otros));
        }else if($rule == 'in'){
            array_push($this->validates, $this->in($fields, $otros));
        }else if($rule == 'numeric'){
            array_push($this->validates, $this->numeric($fields));
        }else if($rule == 'phone'){
            array_push($this->validates, $this->phoneNumber($fields));
        }else if($rule == "date"){
            $otros === null ?
            array_push($this->validates, $this->validateDates($fields)) :
            array_push($this->validates, $this->validateDates($fields, $otros));  
        }else if($rule === 'time'){
            $otros === null ?
            array_push($this->validates, $this->validateTimes($fields)) :
            array_push($this->validates, $this->validateTimes($fields, $otros));  
        }else{
            res('Not validate named: '.$rule);
        }
    }

    private function email($fields){
        return $this->contain($fields, ['@']);
    }

    private function numeric(array $fields){
        foreach($fields as $field){
            if(isset($this->datos[$field]) && is_numeric($this->datos[$field]) === false){
                array_push($this->msg, "El campo $field debe de ser un numero");
                return false;
            }
        }
        return true;
    }


    private function in($needle, $array = null) {
        $haystack = ($array === null) ? $this->datos : $array;
    
        if (is_array($needle)) {
            return count(array_intersect($needle, $haystack)) > 0;
        } else {
            return in_array($needle, $haystack);
        }
    }
    

    private function is(mixed $data, string $type): bool {
        if ($type === 'number') {
            return is_numeric($data);
        }
        return gettype($data) === $type;
    }
    
    

    public function required($fields){
        foreach($fields as $field){
            if(!isset($this->datos[$field])){
                array_push($this->msg, "El campo '$field' no existe.");
                return false;
            }
            if((empty($this->datos[$field]) && $this->datos[$field] !== false) || $this->datos[$field] === null){
                array_push($this->msg, "El campo $field esta vacio.");
                return false;
            }
        }
        return true;
    }

    public function equals(string ...$data) {
        return count(array_unique($data)) === 1;
    }
    

    public function contain($sentenses, $contains){
        foreach($sentenses as $sentense){
            $input = $this->input($sentense);
            if(!$input){
                return false;
            }
            foreach($contains as $contain){
                if(!str_contains($input, $contain)){
                    array_push($this->msg, "$sentense no contiene $contain");
                    return false;
                }
            }
        }
        return true;
    }



    function phoneNumber($phones) {
        $cleanedPhones = array();
        
        foreach ($phones as $index) {
            $phone = $this->input($index);
            if (!$phone) {
                return false;
            }
            
            $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
            $cleanedPhones[] = $cleanPhone;
        }
    
        $isValid = true;
        
        foreach ($cleanedPhones as $cleanPhone) {
            if ($cleanPhone === false || preg_match('/^\+?[0-9]+$/', $cleanPhone) !== 1) {
                array_push($this->msg, "El número de teléfono ".$phone." no es válido. Debe contener solo números y opcionalmente el signo '+' al inicio.");
                $isValid = false;
                break;
            }
        }
    
        return $isValid;
    }
    
    
    

    public function validateDate($date, $dateFormat = 'Y-m-d', $posterior = true) {
        $currentDate = date($dateFormat);
        if (!strtotime($date) || ($posterior && $date < $currentDate) || (!$posterior && $date > $currentDate)) {
            return false; 
        }
    
        return true;
    }

    public function validateDates(array $fields, array $data = [
        "format" => 'Y-m-d',
        "post" => true
    ]) {
        if(!isset($data['format']) || !isset($data['post'])){
            throw new Exception("Missing config in validates date: format or post");
        }
        foreach($fields as $field){
            $date = $this->input($field);
            if(!$date){
                array_push($this->msg, "No existe el campo ".$field);
                return false;
            }
            if(!$this->validateDate($date, $data['format'], $data['post'])){
                $message = ($data['post']) ? "La fecha ".$date." debe ser posterior a la fecha actual y estar en el formato ".$data['format']."." : "La fecha ".$date." debe estar en el formato ".$data['format'].".";
                array_push($this->msg, $message);
                return false;
            }
            
            
        }
        return true;
    }

    public function validateTime($time, $formatTime = 'H:i:s') {
        $timestamp = strtotime($time);
        if ($timestamp === false || date($formatTime, $timestamp) !== $time) {
            return false; 
        }
        return true; 
    }
    
    public function validateTimes(array $fields, array $data = [
        "format" => 'H:i' //antes estaba como H:i:s pero el navegador lo envia como H:i
    ]) {
        if(!isset($data['format'])){
            throw new Exception("Configuración faltante en validación de tiempos: formato");
        }
        foreach($fields as $field){
            $time = $this->input($field);
            if(!$time){
                array_push($this->msg, "El campo ".$field." no existe");
                return false;
            }
            if(!$this->validateTime($time, $data['format'])){
                array_push($this->msg, "La hora ".$time." no cumple con el formato esperado ".$data['format'].".");
                return false;
            }            
        }
        return true;
    }
    

    public function validate(){
        foreach($this->validates as $validate){
            if($validate === false){
                return false;
                break;
            }
        }
        $this->setForNewValidate();
        return true;
    }

    public function input($index) : bool|string|array{
        if(isset($this->datos[$index])){
            return $this->datos[$index];
        }
        return false; 
    }  

    public function err(){
        return $this->msg;
    }

    public function setForNewValidate(){
        $this->msg = [];
        $this->validates = [];
    }
}