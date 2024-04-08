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
        if ($position !== "last" && ($position < 0 || $position > count($this->columns))) {
            throw new Exception("Invalid column position: ".$position);
        }
        $position = $this->addColumn($columnName, $position);
        foreach ($this->rows as &$row) {
            array_splice($row, $position, 0, [isset($rowCells[key($rowCells)]) ? current($rowCells) : null]);
            next($rowCells);
        }
    }
    
    
    public function getChunkColumnWithCell(int $position) {
        if ($position < 0 || $position >= count($this->columns)) {
            throw new Exception("Invalid column position: ".$position);
        }
        $columnName = isset($this->columns[$position]) ? $this->columns[$position] : null;
        $columnData = []; 
        foreach($this->rows as $row) {
            $countCell = 0;
            foreach($row as $cell) {
                $countCell = $countCell + 1;
                if ($countCell - 1 == $position) {
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
    
    
    
    
    

    public function addColumnWithModalButtons(string $nameColumn, string $buttonName, string $titleModal, string $action, string $htmlRender, array $keysToSend, int|string $position = 'last', array $atributes = []) {
        $positionColumn = $this->addColumn($nameColumn, $position);
        foreach ($this->rows as &$row) {
            $modal = new Modal($this->replaceVariables($titleModal, $row), $action);
            $htmlToRenderIntoModal = $this->replaceVariables($htmlRender, $row);
            foreach ($keysToSend as $valueKey) {
                if (array_key_exists($valueKey, $row)) {
                    $htmlToRenderIntoModal .= $modal->inputSendHidden($valueKey, $row[$valueKey]);
                } else {
                    throw new Exception("The key '$valueKey' does not exist when add");
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

    private function replaceVariables(string $string, array $variables) : string {
        $pattern = '/\{\{(\w+)\}\}/';
        $result = preg_replace_callback($pattern, function($matches) use ($variables) {
            $variableName = $matches[1];
            if (array_key_exists($variableName, $variables)) {
                return $variables[$variableName];
            }else{
                throw new Exception("The key '".$variableName."' dont exist when replace");
            }
            return $matches[0];
        }, $string);
    
        return $result;
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
    
}