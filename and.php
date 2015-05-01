<?
header ("Content-type: text/plain");
include("config.php");
require("andwhere.class.php");

//DoQuery("and occurrence like '2015-05-01%'");

try {
    $awp = new AndWhere();
    $awp->AddCondition ('occurrence','2015-04-20%','LIKE');
    $db = ConnectPDO();
    $q = 'SELECT * FROM count WHERE 1 '.$awp->AndWhereString();
    $stmt = $db->prepare($q);
    $stmt = $awp->Bind($stmt);
    $stmt->execute();
    print_r ($stmt->fetchAll());

} catch (PDOException $e) {
    CatchPDO($e);
  }


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