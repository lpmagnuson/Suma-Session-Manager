<?
header ("Content-type: text/plain");
include("config.php");
include("class.php");

//DoQuery("and occurrence like '2015-05-01%'");

try {
    $awp = new AndWhere();
    $awp->addCondition ('occurrence','2015-04-20%','LIKE');
    $db = ConnectPDO();
    $q = 'SELECT * FROM count WHERE '.$awp->field.' '.$awp->operator.' '. $awp->placeholder;
    $stmt = $db->prepare($q);
    
    $stmt->bindParam($awp->placeholder,$awp->value,$awp->param_type);
    $stmt->execute();
    print_r ($stmt->fetchAll());
} catch (PDOException $e) {
    CatchPDO($e);
  }


/*


function DoQuery($and_where="") {
    if (isset($and_where) and ($and_where != "")) {
        print "<li>Got an 'and_where': $and_where </li>";
        $and_where_injector = $and_where;
    }
    else {
        $and_where_injector = '';
    }
    try {
        $db = ConnectPDO();
        $stmt = $db->query("SELECT * FROM count WHERE 1 $and_where_injector order by occurrence DESC LIMIT 0,10");
        print_r($stmt->fetchAll());
    }
    catch (PDOException $e)  {
        CatchPDO($e);
    }
}
*/

function CatchPDO ($e) {
        echo "An Error occured!"; //user friendly message
        echo ($e->getMessage());
        echo (" in file: " . $e->getFile());
        echo (" on line: " . $e->getLine());
}

function ConnectPDO () {
    $db = new PDO('mysql:'.MYSQL_HOST.'=localhost;dbname='.MYSQL_DATABASE.';charset=utf8', MYSQL_USER, MYSQL_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
?>