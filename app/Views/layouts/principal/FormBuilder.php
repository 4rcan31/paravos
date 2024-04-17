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
        $attributeString = '';
        foreach ($attributes as $attribute => $attrValue) {
            $attributeString .= $attribute . '="' . $attrValue . '" ';
        }
    
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
        foreach ($options as $value => $text) {
            $isSelected = $value == $selected ? 'selected' : '';
            $htmlContent .= '<option ' . $isSelected . '>' . $text . '</option>';
        }
        $htmlContent .= '</select>';
        return $this->renderField($label, $name, $htmlContent);
    }

    public function justAdd(string $title, string $html){
        return '
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h5 class="card-title">' . $title . '</h5>
                <div class="card-text" style="white-space: pre-wrap;">' . $html . '</div>
            </div>
        </div>';
    }
}