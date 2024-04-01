<?php
layout("principal/DataTable");
layout("principal/Modal");
class OrdersViewClass{


    private array $table;
    private string $htmlModals = '';
    private array $dataTable;

    
    public function __construct(array $data){
        $this->table = $data['table'];
    }


    public function addColumn(string $name, int|string $position = 'last') {
        if ($position != "last") {
            return $this->insertColumnAtPosition($name, (int)$position);
        } else {
            return $this->insertColumnAtLastPosition($name);
        }
    }
    
    private function insertColumnAtPosition(string $name, int $position): int {
        if ($position < 0 || $position > count($this->table['columns'])) {
            throw new Exception("Invalid position for adding column: ".$position);
        }
        
        array_splice($this->table['columns'], $position, 0, $name);
        return $position;
    }
    
    private function insertColumnAtLastPosition(string $name): int {
        array_push($this->table['columns'], $name);
        return count($this->table['columns']) - 1;
    }
    

    public function addColumnWithModalButtons(string $nameColumn, string $buttonName, string $titleModal, string $action, string $htmlRender, array $keysToSend, int|string $position = 'last') {
        $positionColumn = $this->addColumn($nameColumn, $position);
        foreach ($this->table['rows'] as &$row) {
            $modal = new Modal($this->replaceVariables($titleModal, $row), $action);
            $htmlToRenderIntoModal = $this->replaceVariables($htmlRender, $row);
            foreach ($keysToSend as $valueKey) {
                if (array_key_exists($valueKey, $row)) {
                    $htmlToRenderIntoModal .= $modal->inputSendHidden($valueKey, $row[$valueKey]);
                } else {
                    throw new Exception("The key $valueKey does not exist");
                }
            }
            $modal->setHtmlToRender($htmlToRenderIntoModal);
            $idButtonModal = $modal->getId();
            $this->htmlModals .= $modal->get();
            $buttonHtml = '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#'.$idButtonModal.'">'.$buttonName.'</button>';
            array_splice($row, $positionColumn, 0, $buttonHtml);
        }
    }
    


    public function buildTable(){
        $this->addColumnWithModalButtons(
            "Cancelar Orden", // Nombre de la columna
            "Cancelar Pedido", // Texto del botón
            "Cancelando el pedido {{name}}", // Título del modal
            route("api/v1/cancelar-pedido", false), // Acción que se realizará al confirmar
            "¿Estás seguro que deseas cancelar el pedido con número {{tracking_number}} llamado {{name}}?", // Mensaje de confirmación
            ["tracking_number"], // Claves de los datos a enviar al modal
            2
        );
        
        $dataTable = new DataTable($this->table['columns'], $this->table['rows']);
        $this->dataTable = [
            "component" => $dataTable,
            "id" =>  $dataTable->getId()
        ];
    }

    public function getIdTable(){
        return $this->dataTable['id'];
    }

    public function renderTable(){
        $this->dataTable['component']->render();
    }

    public function renderModal(){
        echo $this->htmlModals;
    }

    public function render(){
        $this->renderModal();
        $this->renderTable();
    }
    

    private function replaceVariables(string $string, array $variables) : string {
        $pattern = '/\{\{(\w+)\}\}/';
        $result = preg_replace_callback($pattern, function($matches) use ($variables) {
            $variableName = $matches[1];
            if (array_key_exists($variableName, $variables)) {
                return $variables[$variableName];
            }else{
                throw new Exception("The key ".$variableName." dont exist!");
            }
            return $matches[0];
        }, $string);
    
        return $result;
    }
}