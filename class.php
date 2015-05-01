<?

class AndWhere {
    public $field;
    public $value;
    public $operator;
    public $type;
    public $param_type;
    public $placeholder;

    public function __construct () {
    }

    public function AddCondition ($field,$value,$operator='=',$type='str') {
        $this->field = $field;
        $this->value = $value;
        $this->operator = $operator;
        $this->type = $type;
        $this->placeholder = ':' . $field;
        
        switch ($type) {
        case 'str': 
            $this->param_type = PDO::PARAM_STR;
            break;
        case 'int': 
            $this->param_type = PDO::PARAM_INT;
            break;
        }
    }


} //end class



$awp = new AndWhere('occurrence','2015-05-01%','LIKE');



?>