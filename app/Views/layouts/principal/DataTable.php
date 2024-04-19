<?php


class DataTable{

    private array $columns;
    private array $rows;
    private string $id;
    private string $htmlModals = '';

    function __construct(array|object $columns, array|object $rows){
        $this->id = $this->id();
        $this->columns = is_object($columns) ? objectToArray($columns) : $columns;
        $this->rows = is_object($rows) ? objectToArray($rows) : $rows;   
    }

    public function initTable(){
        return'<table id="'.$this->id.'" class="table table-striped" style="width:100%">';
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
        return '</table>';
    }

    public function build(){
        return $this->initTable().$this->head().$this->body().$this->foot().$this->endTable().$this->htmlModals;
    }

    public function id(){
        return "table_".uniqid();
    }

    public function getId(){
        return $this->id;
    }

    public function get(){
        return $this->build();
    }

    public function render(){
        echo $this->get();
    }

    public function addColumnWithModalButtons(string $nameColumn, string $buttonName, string $titleModal, string $action, string $htmlRender, array $keysToSend, int|string $position = 'last') {
        $positionColumn = $this->addColumn($nameColumn, $position);
        foreach ($this->rows as &$row) {
            $modal = new Modal($this->replaceVariables($titleModal, $row), $action);
            $htmlToRenderIntoModal = $this->replaceVariables($htmlRender, $row);
            foreach ($keysToSend as $valueKey) {
                if (array_key_exists($valueKey, $row)) {
                    $htmlToRenderIntoModal .= $modal->form()->inputSendHidden($valueKey, $row[$valueKey]);
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


    public function addColumn(string $name, int|string $position = 'last') {
        return $position != "last" ? 
        $this->insertColumnAtPosition($name, (int)$position) :
        $this->insertColumnAtLastPosition($name);
    }
    
    private function insertColumnAtPosition(string $name, int $position): int {
        if ($position < 0 || $position > count($this->columns)) {
            throw new Exception("Invalid position for adding column: ".$position);
        }
        
        array_splice($this->columns, $position, 0, $name);
        return $position;
    }
    
    private function insertColumnAtLastPosition(string $name): int {
        array_push($this->columns, $name);
        return count($this->columns) - 1;
    }
}