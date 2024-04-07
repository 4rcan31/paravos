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
    
    public function buildTable(){
        $dataTable = new DataTable($this->table['columns'], $this->table['rows']);
        $dataTable->addColumnWithModalButtons(
            "Cancelar Orden", // Nombre de la columna
            "Cancelar Pedido", // Texto del botón
            "Cancelando el pedido {{name}}", // Título del modal
            route("api/v1/cancelar-pedido", false), // Acción que se realizará al confirmar
            "¿Estás seguro que deseas cancelar el pedido con número {{tracking_number}} llamado {{name}}?", // Mensaje de confirmación
            ["tracking_number"], // Claves de los datos a enviar al modal
            3
        );
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
}