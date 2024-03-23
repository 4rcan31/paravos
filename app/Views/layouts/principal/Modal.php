<?php


class Modal {

    private string $id;
    private string $title;
    private string $closeButtonName = "Cerrar";
    private string $saveButtonName = "Guardar";
    private string $htmlToRenderIntoModal = '';
    private string $actionRute;
    private string $method = 'POST';

    public function __construct(string $title, string $action) {
        $this->id = $this->generateId();
        $this->title = $title;
        $this->actionRute = $action;
    }

    private function generateId() {
        return "modal_" . uniqid();
    }

    public function setMethod(string $method) : void{
        $this->method = $method;
    }

    public function getId(): string {
        return $this->id;
    }

    public function setHtmlToRender(string $html): void {
        $this->htmlToRenderIntoModal = $html;
    }

    public function setCloseButtonName(string $name): void {
        $this->closeButtonName = $name;
    }

    public function setSaveButtonName(string $name): void {
        $this->saveButtonName = $name;
    }
    

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
    
    function input(string $label, string $name, string $value = '', string $type = 'text') : string {
        $htmlContent = '<input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" ' . (strpos($label, '*') !== false ? "required" : "") . ' value="' . $value . '" >';
        return $this->renderField($label, $name, $htmlContent);
    }
    
    function textarea(string $label, string $name, string $value = '') : string {
        $htmlContent = '<textarea class="form-control" id="' . $name . '" name="' . $name . '" ' . (strpos($label, '*') !== false ? "required" : "") . '>' . $value . '</textarea>';
        return $this->renderField($label, $name, $htmlContent);
    }
    
    
    
    
    

    public function modal(): string {
        return '<div class="modal fade" id="' . $this->id . '" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1" aria-labelledby="' . $this->id . 'Label" aria-hidden="true" style="z-index: 100000;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="z-index: 100000;">
                <div class="modal-content" style="position: relative; z-index: 100000;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="' . $this->id . 'Label">' . $this->title . '</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="' . $this->actionRute . '" method="' . $this->method . '">
                            ' . $this->htmlToRenderIntoModal . '
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">' . $this->saveButtonName . '</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . $this->closeButtonName . '</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }
    
    

    public function render(): void {
        echo $this->modal();
    }

}
