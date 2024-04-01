<?php


class DataTable{

    private array $columns;
    private array $rows;
    private string $id;

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
        return $this->initTable().$this->head().$this->body().$this->foot().$this->endTable();
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
}