<html>
<head>
<title>Suma Session Manager</title>
<style>
form { display: inline }
.highlight { background-color: yellow }
</style>
<script type="text/javascript"
         src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.js">
</script>
<link rel="stylesheet" type="text/css" href="style.css" type="text/css" />

<script type="text/javascript">
     $(document).ready(function() {
             $('tr').mousedown(function() {
                     $(this).parent().children().removeClass('highlight');
                     $(this).addClass('highlight');
                 });
             $('.adjust-time').click(function() {
                     var row=$(this).closest('tr');
                     //                     var id=$(this).closest('tr').children().first().text();
                     var id=row.children().first().text();
                     var transaction=row.children(':nth-child(5)').text();
                     
                 });
         });
</script>
</head>
<body>
<div id="wrapper">
<div id="content">
<h1>Suma Session Manager</h1>
<?
include ("config.php");
include ("functions.php");
$dblink = mysql_pconnect($mysql_host,$mysql_user,$mysql_password) or die ("cannot connect");
mysql_select_db($mysql_database,$dblink) or die ("cannot select database");

$current_init = $default_init;

$offset = (isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0);

if ($_REQUEST['action'] == "move_session") {
    MoveSession($_REQUEST['session_id'], $_REQUEST['transaction_id'], $_REQUEST['time_shift']);
    print '<hr>';
}
if ($_REQUEST['action'] == "delete_session") {
    DeleteUndelete("delete",$_REQUEST['session_id']);
    print '<hr>';
}
elseif ($_REQUEST['action'] == "undelete_session") {
    DeleteUndelete("undelete",$_REQUEST['session_id']);
    print '<hr>';
}

if (isset($_REQUEST['date_search'])) {
    $and_where = "AND `start` LIKE '".$_REQUEST['date_search']."%'";
}

ShowEntries ($current_init, $offset, $entries_per_page, $and_where);        

print "</div><!--id=content-->\n";

print '<div id="footer">';
include("license.php");
print "</div><!--id=footer-->\n";
print "</div><!--id=wrapper-->\n";

?>

</body>
