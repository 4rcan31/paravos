<?php
layout("admin/DataTablePanel");
layout("principal/Modal");
layout("principal/FormBuilder");


/* 
    Solamente las columnas que se muestran son las que se podran editar (por el momento sera asi)
*/
class Crud{

    public array $rows;
    public array $columns;
    public array $columnsToShow = []; //por defecto seran todas
    public array $columnsShowInTable;
    public string $html;
    public DataTablePanel $dataTable;
    public DataTablePanel $dataTableCopyTempWithAllColumns;
    public string|null $identifier = "id";


    public function __construct(array|object $table){
        $table = is_object($table) ? objectToArray($table) : $table;
        $this->rows = $table['rows'];
        $this->columns = $table['columns'];
        $this->dataTableCopyTempWithAllColumns = new DataTablePanel(
            $this->columns,
            $this->rows,
            "This table is temporaly and never will rendered"
        );
        $this->html = '';
    }

    public function setColumnsShowInTable(string ...$columns): void {
        $this->columnsShowInTable = $columns;
    }

    public function setIdentifier(string $identifierName){
        foreach($this->rows as $row){
            if(isset($row[$identifierName])){
                $this->identifier = $identifierName;
                return;
            }
        }
        throw new Exception("The indentifier $identifierName not found in rows");
    }

    public function getIndentifier(){
        return $this->identifier;
    }

    public function setViewDataColumnsTable(string $titleTable){
        $columnsToShow = empty($this->columnsShowInTable) ? $this->columns : $this->columnsShowInTable;
        $filteredRows = empty($this->columnsShowInTable) ? $this->rows : $this->filterRowsByColumns($this->columnsShowInTable, $this->rows);
        $this->dataTable = new DataTablePanel(
            $columnsToShow,
            $filteredRows,
            $titleTable
        );
/*         $this->dataTable->insertHtmlInHeaderTittleCard('
        <button type="button" class="btn btn-warning">Botón Amarillo</button>'); */
    }


    public function setEditButton(string $name, string $action, string $titleModal = ''){
        $formInputHtml = '';
        $form = new FormBuilder;
        $columns = empty($this->columnsShowInTable) ? $this->columns : $this->columnsShowInTable;
        foreach ($columns as $column) {
            //no se por que tengo que ponerle 3 {{{}}} para que cuando llega al nevegador me lo quita, no tengo idea
            $formInputHtml .= $form->input("Editando $column", $column, "{{{$column}}}"); 
        }
        $positionInsert = 'last';
        $this->dataTableCopyTempWithAllColumns->addColumnWithModalButtons(
            "Editar",
            $name,
            $titleModal == '' ? "Editando" : $titleModal,
            $action,
            $formInputHtml,
            [$this->getIndentifier() . ":identifier"], //esto es lo que se esta mandando por hidden, pero en realidad, no se necesita mandar nada xd
            $positionInsert, //esta es la posicion
            [
                "class" => 'btn btn-warning'
            ]
        );
        $columnsCells = $this->dataTableCopyTempWithAllColumns->getChunkColumnWithCell($positionInsert);
        $this->dataTableCopyTempWithAllColumns->removeChunkColumn($positionInsert);
        $this->dataTable->insertChunkColumnWithCell(
            $columnsCells['column'],
            $columnsCells['rowCells'],
            $positionInsert);
    }




    public function setCancelButton(string $name, string $action, string $htmlDinamic, array $filedDinamicToSend = [], string $titleModal = ''){
        $send = array_merge($filedDinamicToSend, [$this->getIndentifier() . ":identifier"]);
        $positionInsert = 'last';
        $this->dataTableCopyTempWithAllColumns->addColumnWithModalButtons(
            "Cancelar",
            $name,
            $titleModal == '' ? "Cancelando" : $titleModal,
            $action,
            $htmlDinamic,
            $send,
            "last",
            [
                "class" => 'btn btn-danger'
            ]
        );
        $columnsCells = $this->dataTableCopyTempWithAllColumns->getChunkColumnWithCell($positionInsert);
        $this->dataTableCopyTempWithAllColumns->removeChunkColumn($positionInsert);
        $this->dataTable->insertChunkColumnWithCell(
            $columnsCells['column'],
            $columnsCells['rowCells'],
            $positionInsert);
    }

    public function setViewAllRowTheTableOriginalInModal(){
        $formInputHtml = '';
        $form = new FormBuilder;
        foreach ($this->columns as $column) {
            //no se por que tengo que ponerle 3 {{{}}} para que cuando llega al nevegador me lo quita, no tengo idea
            $formInputHtml .= $form->input("Viendo a $column", $column, "{{{$column}}}", "text", [
                'readonly' => 'true'
            ]); 
        }
        $positionInsert = 'last';
        $this->dataTableCopyTempWithAllColumns->addColumnWithModalButtons(
            "Ver",
            "Ver",
            "Esto es un titulo",
            "/null", //esto es la ruta para no enviar el form a ninguna parte
            $formInputHtml,
            [],
            $positionInsert
        );
        $columnChuck = $this->dataTableCopyTempWithAllColumns->getChunkColumnWithCell($positionInsert);
        $this->dataTableCopyTempWithAllColumns->removeChunkColumn($positionInsert);
        //insertar en la tabla original
        $this->dataTable->insertChunkColumnWithCell(
            $columnChuck['column'],
            $columnChuck['rowCells'],
            $positionInsert
        );
      //  $this->html .= $this->dataTableCopyTempWithAllColumns->getHtmlModal(); //esto dejo de hacer falta creo xd

    }

    public function setCreateButton(string $titleMolda, string $action, bool $useAll = true, string $nameButton = "Nuevo"){
        $modal = new Modal($titleMolda, $action);
        if ($useAll) {
            $columns = $this->columns;
        } elseif (!empty($this->columnsShowInTable)) {
            $columns = $this->columnsShowInTable;
        } else {
            throw new Exception("You want to use all columns but have not specified which columns to use.");
        }        
        $form = '';
        foreach($columns as $column){
            $form .= $modal->input("$column*", $column);
        }
        $modal->setHtmlToRender($form);
        $idButtonModal = $modal->getId();
        $button = '<button';
        $button .= ' type="button" class="btn btn-primary"';
        $button .= 'data-bs-toggle="modal" data-bs-target="#' . $idButtonModal . '"';
        $button .= '>'.$nameButton.'</button>';
        $this->dataTable->insertHtmlInHeaderTittleCard($button);
        $this->html .= $modal->get();
    }

    public function setColumnForNumberRows(){
        $rowsCells = [];
        for($i = 0; $i < count($this->rows); $i++){
            $rowsCells[] = $i + 1;
        }
        $this->dataTable->insertChunkColumnWithCell(
            "N", $rowsCells, 0
        );
    }


    public function build(){
        $this->html .= $this->dataTableCopyTempWithAllColumns->getHtmlModal();
        $this->html .= $this->dataTable->get();
    }

    public function render(){
        echo $this->html;
    }

    public function datatable() : DataTablePanel{
        return $this->dataTable;
    }

    function filterRowsByColumns(array $columns, array $rows): array {
        $filteredRows = [];
        foreach ($rows as $row) {
            $filteredRow = [];
            foreach ($columns as $column) {
                if (array_key_exists($column, $row)) {
                    $filteredRow[$column] = $row[$column];
                }else{
                    throw new Exception("The column $column dont exist");
                }
            }
            $filteredRows[] = $filteredRow;
        }
        return $filteredRows;
    }
}