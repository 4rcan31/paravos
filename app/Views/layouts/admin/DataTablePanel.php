<?php


class DataTablePanel{

    private array $columns;
    private array $rows;
    private string $id;
    private string $htmlModals = '';
    private string $titleCard;
    private string $htmlInTittleCard = '';

    function __construct(array|object $columns, array|object $rows, string $titleCard){
        $this->id = $this->id();
        $this->titleCard = $titleCard;
        $this->columns = is_object($columns) ? objectToArray($columns) : $columns;
        $this->rows = is_object($rows) ? objectToArray($rows) : $rows;   
    }
    
    public function titleCard(){
        return '<div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">'.$this->titleCard.'</h6>
            '.$this->htmlInTittleCard.'
        </div>';
    }
    

    public function insertHtmlInHeaderTittleCard(string $html) : void{
        $this->htmlInTittleCard = $html;
    }


    public function initTable(){
        $html = '<div class="card shadow mb-4">';
        $html .= $this->titleCard();
        $html .= '<div class="card-body">';
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table table-bordered" id="'.$this->id.'" width="100%" cellspacing="0">';
        return $html;
    }
    
    
    public function head(){
        $html = '<thead>';
        $html .= '<tr>';
        foreach($this->columns as $column){
            $html .= '<th>'.$column.'</th>';
        }
        $html .= '</tr>';
        $html .= '</thead>';
        return $html;
    }

    public function body(){
        $html = '<tbody>';
        foreach($this->rows as $row){
            $html .= '<tr>';
            foreach($row as $cell){
                $html .= '<td>'.$cell.'</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        return $html;
    }

    public function foot(){
        $html = '<tfoot>';
        $html .= '<tr>';
        foreach($this->columns as $column){
            $html .= '<th>'.$column.'</th>';
        }
        $html .= '</tr>';
        $html .= '</tfoot>';
        return $html;
    }

    public function endTable(){
        return '</table></div></div></div>';
    }

    public function build() : string{
        return $this->initTable().$this->head().$this->body().$this->foot().$this->endTable().$this->htmlModals;
    }

    public function id(){
        return "table_".uniqid();
    }

    public function getId(){
        return $this->id;
    }

    public function get() : string{
        return $this->build();
    }

    public function render() : void{
        echo $this->get();
    }

    public function getRows() : array{
        return $this->rows;
    }

    public function getColumns() : array{
        return $this->columns;
    }

    public function getHtmlModal() : string{
        return $this->htmlModals;
    }

    public function addColumn(string $name, int|string $position = 'last') : int {
        return $position != "last" ? 
        $this->insertColumnAtPosition($name, (int)$position) :
        $this->insertColumnAtLastPosition($name);
    }

    public function insertChunkColumnWithCell(string $columnName, array $rowCells, int|string $position = 'last') {
        $rowCount = count($this->rows) - 1;
        $columnsCount = count($this->columns) - 1;
        $rowCellsCount = count($rowCells) - 1;
        if ($position !== "last" && ($position < 0 || $position > $columnsCount)) {
            throw new Exception("Invalid column position: ".$position);
        }
        if($rowCellsCount != $rowCount){
            throw new Exception(
                $rowCellsCount > $rowCount ? 
                "There is an overflow in the number of cells you want to insert" : 
                "There are not enough cells to fill the entire table");
        }
        $position = $this->addColumn($columnName, $position);
        foreach ($this->rows as &$row) {
            $cellToInsert = array_shift($rowCells);
            $position === 'last' ?
            $row[] = $cellToInsert :
            array_splice($row, $position, 0, $cellToInsert);
        }
    }
    
    
    
    public function getChunkColumnWithCell(int|string $position = 'last') {
        if($position === 'last'){
            $position = count($this->columns) - 1;
        }
        if ($position < 0 || $position > (count($this->columns) - 1)) {
            throw new Exception("Invalid column position: ".$position);
        }
        $columnName = isset($this->columns[$position]) ? $this->columns[$position] : null;
        $columnData = []; 
        foreach($this->rows as $row) {
            $countCell = 0;
            foreach($row as $cell) {
                $countCell++;
                if ($countCell - 1 === $position) {
                    $columnData[] = $cell; 
                    break;
                }
            }
        }
    
        return [
            'column' => $columnName,
            'rowCells' => $columnData
        ];
    }
    

    public function removeChunkColumn(int|string $position = 'last') {
        if($position == 'last'){
            $positionColumn = count($this->columns) - 1;
        }
        //eliminar el encambezado de la columna y ordenarlo
        unset($this->columns[$positionColumn]);
        sort($this->columns);
        for($i = 0; $i < count($this->rows); $i++){
            if($position == 'last'){
                $countThisCellsPosition = count($this->rows[$i]) - 1;
                unset($this->rows[$i][$countThisCellsPosition]);
            }
            $countCell = 0;
            foreach($this->rows[$i] as $index => $cell) {
                $countCell = $countCell + 1;
                if ($countCell - 1 == $position) {
                    unset($this->rows[$i][$index]);
                }
            }

        }
    }
    
    public function addColumnWithModalButtons(string $nameColumn, string $buttonName, string $titleModal, string $action, string|array $htmlRender, array $keysToSend, int|string $position = 'last', array $atributes = []) {
        $positionColumn = $this->addColumn($nameColumn, $position);
        foreach ($this->rows as &$row) {
            if(is_string($htmlRender)){
                $modal = new Modal($this->replaceVariables($titleModal, $row), $action);
            }else if(is_array($htmlRender)){
                $modal = new Modal($this->replaceVariables($titleModal, $row), $action);
                $form = new FormBuilder;
                $htmlFinal = '';
                $htmlInserteBefore = '';
                foreach($htmlRender as $key => $input){
                    if($key == 'html'){
                        //esto significa que mando algo mas, un html en forma de string y no de array que quiere
                        //que se inserte al html que se va a generar
                        $htmlInserteBefore .= $input;
                        continue;
                    }
                    $title = $input[0] ?? "No se definio el titulo";
                    $name = $input[1] ?? "no_se_definio_el_nombre".token();
                    $type = $input[2] ?? "text";
                    $atributesInput = $input[3] ?? [];
                    if($type == '{{type}}'){
                        //la conversion de type php a type html input ya la hace $form->input()
                        $type = (string)$this->runFunctionInVars($name, 'type', $row);
                    }
                   // $ishtml = (bool)$this->replaceVariables("{{" . $name . ".ishtml}}", $row);
                    $ishtml = (bool)$this->runFunctionInVars($name, 'ishtml', $row);
                    if($ishtml){
                        $htmlFinal .= $form->justAdd(
                            $this->replaceVariables($title, $row),
                            $this->replaceVariables("{{" . $name . "}}", $row)
                        );
                    }else{
                        //prettyPrint("Esto es lo que quedo xd: " .$type);
                        $htmlFinal .= $form->input(
                            $this->replaceVariables($title, $row),
                            $name,
                            $this->replaceVariables("{{" . $name . "}}", $row),
                            $type,
                            $atributesInput
                        );
                    }
                    
                }
                $htmlFinal .= $htmlInserteBefore;
            }
           
            $htmlToRenderIntoModal = $this->replaceVariables(
                is_string($htmlRender) ? $htmlRender : $htmlFinal, $row);
            foreach ($keysToSend as $valueKey) {
                $identifier = $this->identifierKeyCleaner($valueKey);
                $value = array_key_exists($valueKey, $row) ? 
                        $row[$valueKey] : 
                        (array_key_exists($identifier, $row) ? 
                        $row[$identifier] : null);
                if ($value !== null) {
                    $htmlToRenderIntoModal .= $modal->form()->inputSendHidden($identifier !== '' ? 'identifier' : $valueKey, $value);
                } else {
                    throw new Exception("The key '$valueKey' does not exist when adding.");
                }
            }
            $modal->setHtmlToRender($htmlToRenderIntoModal);
            $idButtonModal = $modal->getId();
            $this->htmlModals .= $modal->get();
            $atribuesString = '';
            foreach($atributes as $atribute => $value){
                $atribuesString .= $atribute . '="' . $value . '"';
            }
            $buttonHtml = '<button ' . 
            ($atribuesString == "" ? 'class="btn btn-primary"' : $atribuesString) . 
            ' data-bs-toggle="modal" data-bs-target="#' . $idButtonModal . '">' . $buttonName . '</button>';            
            array_splice($row, $positionColumn, 0, $buttonHtml);
        }
    }


    
    public function redenderPaginationTableAfterLoadScriptJs(){
        echo '<script>
                $(document).ready(function() {
                    $("#'.$this->getId().'").DataTable();
                });
            </script>';
    }

    public function buildAtributesStringByArray(array $attributes): ?string {
        if (empty($attributes)) {
            return null;
        }
        return implode(' ', array_map(
            fn($key, $value) => "$key=\"$value\"",
            array_keys($attributes),
            $attributes
        ));
    }
    
    public function runFunctionInVars(string $field, string $function, array $variables){
        return $this->replaceVariables("{{".$field.".$function}}", $variables);
    }

    public function replaceVariables(string $string, array $variables) : string {
        $pattern = '/\{\{(\w+(\.\w+)*)\}\}/';
        $result = preg_replace_callback($pattern, function($matches) use ($variables) {
            $variableName = $matches[1];
            // Si el nombre de la variable contiene puntos, significa que es una funcion
            if (strpos($variableName, '.') !== false) {
                // Dividir el nombre de la variable en partes
                $parts = explode('.', $variableName);
                // El primer elemento sera el nombre de la variable
                $variable = $parts[0];
                // El resto de los elementos seran solamente los metodos/funciones
                $functions = array_slice($parts, 1);
                if (array_key_exists($variable, $variables)) {
                    $value = $variables[$variable];
                    foreach ($functions as $function) {
                        switch ($function) {
                            case 'type':
                                if(is_numeric($value)){
                                    $value = "numeric";
                                }else{
                                    $value = gettype($value);
                                }
                                break;
                            case 'ishtml':
                                $value = $this->hasHtmlFormat($value);
                                break;
                            default:
                                throw new Exception("Unsupported function: $function");
                        }
                    }
                    return $value;
                } else {
                    throw new Exception("The key '$variable' doesn't exist when replacing");
                }
            } else {
                // Si no hay funciones, simplemente reemplazar la variable
                if (array_key_exists($variableName, $variables)) {
                    return $variables[$variableName];
                } else {
                    throw new Exception("The key '$variableName' doesn't exist when replacing");
                }
            }
        }, $string);
    
        return $result;
    }
    
    private function hasHtmlFormat($string) {
        return (bool)hasHtmlFormat($string);
    }
    

    private function insertColumnAtPosition(string $name, int $position): int {
        return $this->insertItemAtPosition($this->columns, $name, $position);
    }
    
    private function insertColumnAtLastPosition(string $name): int {
        return $this->insertItemAtLastPosition($this->columns, $name);
    }

    private function insertItemAtPosition(array &$array, $item, int $position): int {
        if ($position < 0 || $position > count($array)) {
            throw new Exception("Invalid position for adding item: ".$position);
        }
        
        array_splice($array, $position, 0, array($item));
        return $position;
    }
    
    private function insertItemAtLastPosition(array &$array, $item): int {
        array_push($array, $item);
        return count($array) - 1;
    }

    private function identifierKeyCleaner($string) {
        $colonPosition = strpos($string, ':');
        if ($colonPosition === false || substr($string, $colonPosition + 1) !== 'identifier') {
            return '';
        }
        $leftPart = substr($string, 0, $colonPosition);
        return $leftPart;
    }


    public function loadIn(string $key, string $string, string $nameReplace = "{{element}}"){
        if (empty($this->rows)) {
            throw new Exception("No rows found. Please load data before calling loadIn.");
        }
        foreach($this->rows as $index => &$row){
            if(!array_key_exists($key, $row)){
                throw new Exception("The key '$key' does not exist in the row when trying to load in.");
            }
            if (!strpos($string, $nameReplace)) {
                throw new Exception("The placeholder '$nameReplace' does not exist in the string '$string'.");
            }
            $this->rows[$index][$key] = str_replace($nameReplace,$this->rows[$index][$key], $string);
        }
    }
}