<style>
form { display: inline }
.highlight { background-color: yellow }
</style>
<script type="text/javascript"
         src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.js">
</script>


<script>
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
<?
include ("config.php");
$dblink = mysql_pconnect($mysql_host,$mysql_user,$mysql_password) or die ("cannot connect");
mysql_select_db($mysql_database,$dblink) or die ("cannot select database");

$current_init = $default_init;
// print(InitSelector($current_init));

if ($_REQUEST['action'] == "move_session") {
    print_r($_REQUEST);
    print '<hr>';
}
elseif ($_REQUEST['action'] == "delete_session") {
    print_r($_REQUEST);
    print '<hr>';
}

ShowEntries ($current_init);        

function ShowEntries ($init, $offset=0) { 
    $q = 'SELECT * FROM session WHERE fk_initiative = '.$init.' ORDER BY `id` DESC LIMIT '.$offset.',60';
print $q;
$r = mysql_query($q);

while ($myrow = mysql_fetch_assoc($r)) {
    $headers = array_keys($myrow);
    $rows .= ' <tr>'.PHP_EOL;
    foreach ($headers as $k) {
        $rows .= '  <td class="'.$k.'">'.$myrow[$k].'</td>'.PHP_EOL;
    }
    $rows .= '  <td><form action="?"><input type="hidden" name="action" value="move_session"><input type="hidden" name="session_id" value="' .$myrow['id'] .'"><input type="hidden" name="transaction_id" value="'. $myrow['fk_transaction'] .'">Adjust Time by: ' . DisplayAdjustor() . '</form></td>'. PHP_EOL;
    $rows .= ' </tr>'.PHP_EOL;
} // end while myrow
$header = join('</th><th>',$headers);
$header = '<tr><th>'.$header.'</th></tr>'.PHP_EOL;
$rows = '<table>'. $header . $rows .'</table>'.PHP_EOL;
print ($rows);
} //end function ShowEntries

function DisplayAdjustor() {
    $opts = array ("-60 min" => "subtime 01:00:00",
                   "-30 min" => "subtime 00:30:00",
                   "-15 min" => "subtime 00:15:00",
                   "-10 min" => "subtime 00:10:00",
                   "-5 min"  => "subtime 00:05:00",
                   "+5 min"  => "addtime 00:05:00",
                   "+10 min" => "addtime 00:10:00",
                   "+15 min" => "addtime 00:15:00",
                   "+30 min" => "addtime 00:30:00",
                   "+60 min" => "addtime 01:00:00");
    $select = "<option>Choose One:</option>\n";

    foreach ($opts as $disp => $val) {
        $select .= "<option value=\"$val\">$disp</option>\n";
    }
    return "<select class=\"row-select\">$select</select> <button class=\"adjust-time\">Go</button>\n"; 
}

/*
function MysqlResultsTable ($mysql_results, $table_id='') {
  while ($myrow = mysql_fetch_assoc($mysql_results)) {
    if (! ($headers))
      $headers = array_keys($myrow);
    $rows .= " <tr>\n";
    foreach ($headers as $k)
      $rows .= "  <td class=$k>$myrow[$k]</td>\n";
    $rows .= " </tr>\n";
  } // end while myrow
  $header = join("</th><th>",$headers);
  $header = "<tr><th>$header</th></tr>\n";
  if ($table_id != '') { $id = ' id="'.$table_id.'"'; }
  $rows = "<table$id>$header$rows</table>\n";
  return ($rows);
} //end function MysqlResultsTable
*/
?>