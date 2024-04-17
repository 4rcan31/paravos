<?php


function randomString($length){ //Genera un string aleatorio
    $rand_string = '';
    for($i = 0; $i < $length; $i++) {
        $number = random_int(0, 36);
        $character = base_convert($number, 10, 36);
        $rand_string .= $character;
    }
    return $rand_string;
}


function token($length = 32) {
    return substr(bin2hex(
        random_bytes(ceil($length / 2))
    ), 0, $length);
}

function hasHtmlFormat(string $string) {
    return $string !== strip_tags($string);
}

class StringBuilder {
    private $string;

    public function __construct($string = '') {
        $this->string = $string;
    }

    public function append($string) {
        $this->string .= $string;
        return $this;
    }

    public function toString() {
        return $this->string;
    }

    public function clear() {
        $this->string = '';
        return $this;
    }
}