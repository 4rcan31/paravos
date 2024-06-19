<?php

class Modal {

    private string $id;
    private string $title;
    private string $closeButtonName = "Cerrar";
    private string $saveButtonName = "Guardar";
    private string $htmlToRenderIntoModal = '';
    private string $actionRute;
    private string $method = 'POST';
    private string $ruteWithOutAction = '/null';

    public function __construct(string $title = '', string $action = '/null') {
        $this->id = $this->generateId();
        $this->title = $title;
        $this->actionRute = $action;
    }

    public function setTitle(string $title){
        $this->title = $title;
    }

    public function setAction(string $action){
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

    public function setEndpointWithOutActionForm(string $enpoint) : void{
        $this->ruteWithOutAction = $enpoint;
    }

    public function modal(): string {
        csrf();
        $submitButton = ($this->actionRute === $this->ruteWithOutAction) ? '' : '<button type="submit" class="btn btn-primary">' . $this->saveButtonName . '</button>';
        return '<div class="modal fade" id="' . $this->id . '" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1" aria-labelledby="' . $this->id . 'Label" aria-hidden="true" style="z-index: 100000;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="z-index: 100000;">
                <div class="modal-content" style="position: relative; z-index: 100000;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="' . $this->id . 'Label">' . $this->title . '</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="' . $this->actionRute . '" method="' . $this->method . '" enctype="multipart/form-data">
                            '.TokenCsrf::getInput().'
                            ' . $this->htmlToRenderIntoModal . '
                            <div class="modal-footer">
                                ' . $submitButton . '
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . $this->closeButtonName . '</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
    }

    public function form() : FormBuilder{
        layout("principal/FormBuilder");
        return new FormBuilder;
    }
    
    public function render(): void {
        echo $this->get();
    }

    public function get() : string{
        return $this->modal();
    }

}
