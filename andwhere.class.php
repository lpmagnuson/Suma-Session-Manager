<?
class AndWhere {
    private $conditions; //array of condition-sets 

    public function __construct () {
        $this->conditions = array();
    }

    public function AddCondition ($field,$value,$operator='=',$type='str') {
        $placeholder = ':' . $field;
        
        switch ($type) {
        case 'str': 
            $this->param_type = PDO::PARAM_STR;
            break;
        case 'int': 
            $this->param_type = PDO::PARAM_INT;
            break;
        }

        $condition = array ('field' => $field,
                            'value' => $value,
                            'operator' => $operator,
                            'type'  => $type,
                            'param_type' => $param_type,
                            'placeholder' => $placeholder,
                             );
        array_push($this->conditions, $condition); 

    } //end AddCondition

    public function AndWhereString () {
        $return_string = "";
        foreach ($this->conditions as $a) {
            $return_string .= ' AND '.$a['field'].' '.$a['operator'].' '.$a['placeholder'];
        }
        return $return_string;
    }

    public function Bind ($stmt) {
        foreach ($this->conditions as $a) {
            $stmt->bindParam($a['placeholder'], $a['value'], $a['param_type']);
        }
        return $stmt;
    }

} //end class


?>