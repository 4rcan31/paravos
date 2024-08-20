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
    public string $inputsAddedInCreate = '';
    public array $lessInputsInCreateButton = [];


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
    }



    public function addColumnWithModalButtons(string $name, string $action, string $htmlDinamic, array $filedDinamicToSend = [], string $titleModal = '', string $nameColumn = "Cancelar"){
        $send = array_merge($filedDinamicToSend, [$this->getIndentifier() . ":identifier"]);    
        $positionInsert = 'last';
        $this->dataTableCopyTempWithAllColumns->addColumnWithModalButtons(
            $nameColumn,
            $name,
            $titleModal,
            $action,
            $htmlDinamic,
            $send,
            "last",
            [
                "class" => 'btn btn-primary'
            ]
        );
        $columnsCells = $this->dataTableCopyTempWithAllColumns->getChunkColumnWithCell($positionInsert);
        $this->dataTableCopyTempWithAllColumns->removeChunkColumn($positionInsert);
        $this->dataTable->insertChunkColumnWithCell(
            $columnsCells['column'],
            $columnsCells['rowCells'],
            $positionInsert);
    }


    public function setCancelButton(string $name, string $action, string $htmlDinamic, array $filedDinamicToSend = [], string $titleModal = '', string $nameColumn = "Cancelar"){
        $send = array_merge($filedDinamicToSend, [$this->getIndentifier() . ":identifier"]);
        $positionInsert = 'last';
        $this->dataTableCopyTempWithAllColumns->addColumnWithModalButtons(
            $nameColumn,
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
        $formDataArray = [];
        foreach ($this->columns as $column) {
            //no se por que tengo que ponerle 3 {{{}}} para que cuando llega al nevegador me lo quita, no tengo idea
            $formDataArray[] = [
                "Viendo a $column", //titulo
                $column, //nombre de input y tambien nombre de key
                '{{type}}',  //tipo de input
                [
                    'readonly' => 'true' //atributos del input
                ]
                ];
        }
        $positionInsert = 'last';
        $this->dataTableCopyTempWithAllColumns->addColumnWithModalButtons(
            "Ver",
            "Ver",
            "Esto es un titulo",
            "/null", //esto es la ruta para no enviar el form a ninguna parte
            $formDataArray,
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

    function tryValueAsKey(array $array) {
        $result = [];
        foreach ($array as $value) {
            // Intenta usar el valor como nombre de clave
            // Si el valor ya existe como clave, añade un sufijo numérico para hacerlo único
            $key = $value;
            $suffix = 1;
            while (array_key_exists($key, $result)) {
                $key = $value . '_' . $suffix;
                $suffix++;
            }
            // Asigna el valor al nuevo array usando la clave generada
            $result[$key] = $value;
        }
        return $result;
    }
    

    public function setCreateButton(string $titleMolda, string $action, bool $useAll = false, string $nameButton = "Nuevo"){
        $modal = new Modal($titleMolda, $action);
        if ($useAll) {
            $columns = $this->columns;
        } elseif (!empty($this->columnsShowInTable)) {
            $columns = $this->columnsShowInTable;
        } else {
            throw new Exception("You want to use all columns but have not specified which columns to use in button create.");
        }        
        $form = '';
      
        foreach ($columns as $column) {
            if (empty($this->lessInputsInCreateButton) || !in_array($column, $this->lessInputsInCreateButton)) {

                $type = $this->determineColumnType($column, $this->rows);
                //prettyPrint($type);
                $form .= $modal->form()->input("$column*", $column, "", $type);
            }
        }
        $form .= $this->inputsAddedInCreate;
        $modal->setHtmlToRender($form);
        $idButtonModal = $modal->getId();
        $button = '<button';
        $button .= ' type="button" class="btn btn-primary"';
        $button .= 'data-bs-toggle="modal" data-bs-target="#' . $idButtonModal . '"';
        $button .= '>'.$nameButton.'</button>';
        $this->dataTable->insertHtmlInHeaderTittleCard($button);
        $this->html .= $modal->get();
    }

    public function setEditButton(string $name, string $action, string $titleModal = '', bool $useAll = false){
        if ($useAll) {
            $columns = $this->columns;
        } elseif (!empty($this->columnsShowInTable)) {
            $columns = $this->columnsShowInTable;
        } else {
            throw new Exception("You want to use all columns but have not specified which columns to use in button Edit.");
        }   

        $formDataArray = [];
        foreach ($columns as $column) {
            //no se por que tengo que ponerle 3 {{{}}} para que cuando llega al nevegador me lo quita, no tengo idea
            if (empty($this->lessInputsInCreateButton) || !in_array($column, $this->lessInputsInCreateButton)) {
                $formDataArray[] = [
                    "Editanto a $column", //titulo
                    $column, //nombre de input y tambien nombre de key
                    '{{type}}',  //tipo de input
                    ];
            }

        }
        $formDataArray['html'] = $this->inputsAddedInCreate;



        $positionInsert = 'last';
        $this->dataTableCopyTempWithAllColumns->addColumnWithModalButtons(
            "Editar",
            $name,
            $titleModal == '' ? "Editando" : $titleModal,
            $action,
            $formDataArray,
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

    public function addColumWithRedirectionButton(string $columnName, string $buttonLabel, string $uri, array $atributes = []){
        $this->datatableCopy()->addColumWithRedirectionButton($columnName, $buttonLabel, $uri, $atributes);
        $columnsCells = $this->dataTableCopyTempWithAllColumns->getChunkColumnWithCell();
        $this->dataTableCopyTempWithAllColumns->removeChunkColumn();
        $this->dataTable->insertChunkColumnWithCell(
            $columnsCells['column'],
            $columnsCells['rowCells']);
    }

    public function addOneMoreInputInCreateModal(array $typos) {
        $form = new FormBuilder;
        $label = $typos['label'] ?? "No se especificó el Label";
        $name = $typos['name'] ?? "No se especificó el name";
        $type = $typos['type'] ?? "No se pudo determinar el tipo de input";
        $input = $typos['input'] ?? "No se pudo encontrar la data";
        if (is_array($input)) {
           // prettyPrint($this->rows); die;
            $this->inputsAddedInCreate .= $form->select($label, $name, $input, "{{Alimentos}}");
        } elseif ($type === 'textarea') {
            $this->inputsAddedInCreate .= $form->textarea($label, $name);
        } elseif (is_numeric($input) || is_int($input)) {
            $this->inputsAddedInCreate .= $form->input($label, $name, '', 'number');
        } else {
            $this->inputsAddedInCreate .= $form->input($label, $name, '', $type);
        }
    }

    public function setLessInputInCreateButton(array $inputs){
        $this->lessInputsInCreateButton = $inputs;
    }

    function determineColumnType(string $columnName, array $data): string {
        $columnType = 'unknown';
    
        // Recorrer los datos para determinar el tipo de la columna
        foreach ($data as $row) {
            $value = $row[$columnName];
            
            // Determinar el tipo de dato de la columna
            if (is_numeric($value)) {
                // Si el valor es numérico, actualiza el tipo de la columna a numérico
                $columnType = 'numeric';
            } elseif (is_string($value)) {
                // Si el valor es una cadena, actualiza el tipo de la columna a cadena, 
                // pero solo si aún no se ha detectado como otro tipo
                $columnType = ($columnType === 'unknown' || $columnType === 'string') ? 'string' : $columnType;
            }
            // Si necesitas manejar otros tipos de datos, puedes agregar más condiciones aquí
        }
    
        return $columnType;
    }
    
    

    

    public function setColumnForNumberRows(string $columnName = "N"){
        $rowsCells = [];
        for($i = 0; $i < count($this->rows); $i++){
            $rowsCells[] = $i + 1;
        }
        $this->dataTable->insertChunkColumnWithCell(
            $columnName, $rowsCells, 0
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

    public function datatableCopy() : DataTablePanel{
        return $this->dataTableCopyTempWithAllColumns;
    }



    public function filterRowsByColumns(array $columns, array $rows): array {
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

    public function loadIn(string $name, string $load, array $conditions = []){
        $this->dataTable->loadIn($name, $load, $conditions);
        $this->dataTableCopyTempWithAllColumns->loadIn($name, $load, $conditions);
    }
}