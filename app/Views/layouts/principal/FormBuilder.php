<?php

class FormBuilder{

    function renderField(string $label, string $name, string $htmlContent, string $message = "Campo obligatorio") : string {
        $required = strpos($label, '*') !== false; // Verificar si el label contiene un asterisco
        $label = str_replace('*', '', $label); // Eliminar el asterisco del label
        $html = '<div class="mb-3">';
        $html .= '<label for="' . $name . '" class="form-label">' . $label;
        if ($required) {
            $html .= '<span class="text-danger">*</span>'; // Agregar asterisco si el campo es obligatorio
        }
        $html .= '</label>';
        $html .= $htmlContent;
        if ($required) {
            $html .= '<small class="form-text text-danger small">'.$message.'</small>'; // Agregar mensaje de ayuda en color rojo y tamaño pequeño si el campo es obligatorio
        }
        $html .= '</div>';
        return $html;
    }

    function input(string $label, string $name, string $value = '', string $type = 'text', array $attributes = []) : string {
        // Mapear algunos tipos comunes a los tipos de entrada HTML
        $typeMap = [
            'string' => 'text',
            'numeric' => 'number',
            'integer' => 'number',
            'img'  => 'img',
            'imagen' => 'file',
            'file' => 'file',
            "date" => 'date',
            'time' => 'time'
        ];

        if($type == "numeric" || $type == "integer" || $type == "number"){
            $attributes["step"] = "any";
            $attributes['pattern'] = "[0-9]+";
        }
        $attributeString = '';
        foreach ($attributes as $attribute => $attrValue) {
            $attributeString .= $attribute . '="' . $attrValue . '" ';
        }
        $type = array_key_exists($type, $typeMap) ? 
                $typeMap[$type] : "text";
                $htmlContent = '<input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" ' . $attributeString . (strpos($label, '*') !== false ? "required" : "") . ' value="' . $value . '" >';
                return $this->renderField($label, $name, $htmlContent);
    }
    
    
    function textarea(string $label, string $name, string $value = '') : string {
        $htmlContent = '<textarea class="form-control" id="' . $name . '" name="' . $name . '" ' . (strpos($label, '*') !== false ? "required" : "") . '>' . $value . '</textarea>';
        return $this->renderField($label, $name, $htmlContent);
    }

    function inputSendHidden(string $name, string $value){
        $htmlContent = '<input type="hidden" name="'.$name.'" value="' . $value . '">';
        return $this->renderField("", $name, $htmlContent);
    }

    function select(string $label, string $name, array $options, string $selected = '') : string {
        $htmlContent = '<select class="form-control" id="' . $name . '" name="' . $name . '" ' . (strpos($label, '*') !== false ? "required" : "") . '>';
        $htmlContent .= ' <option value="" disabled selected hidden>Seleccionar</option>';
        foreach ($options as $value => $text) {
            $isSelected = ($value == $selected || $text == $selected) ? 'selected' : '';
            $htmlContent .= '<option value="' . htmlspecialchars($text) . '" ' . $isSelected . '>' . htmlspecialchars($text) . '</option>';
        }
        $htmlContent .= '</select>';
        return $this->renderField($label, $name, $htmlContent);
    }

    public function justAdd(string $title, string $html){
        $var =  '
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-text" style="white-space: pre-wrap;">' . $html . '</div>
            </div>
        </div>';
        return $this->renderField($title, token(), $var);
    }
}