<?
function ShowEntries ($init, $offset=0) { 
    $q = 'SELECT `session`.*,count(`number`) as Counts FROM `session`,`count` WHERE session.fk_initiative = '.$init.' AND session.id = count.fk_session AND count.number = 1 GROUP BY fk_session ORDER BY `session`.`id` DESC LIMIT '.$offset.',60';
print '<p>'.$q.'</p>';
$r = mysql_query($q);

while ($myrow = mysql_fetch_assoc($r)) {
    $headers = array_keys($myrow);
    $rows .= ' <tr>'.PHP_EOL;
    foreach ($headers as $k) {
        $rows .= '  <td class="'.$k.'">'.$myrow[$k].'</td>'.PHP_EOL;
    }
    if ($myrow['deleted'] == 0) {
        $rows .= '<td><form action="?" method="post"><input type="hidden" name="action" value="delete_session"><input type="hidden" name="session_id" value="' .$myrow['id'] .'"><input type="submit" value="Delete"></form></td>'.PHP_EOL;
    }
    elseif ($myrow['deleted'] == 1) {
        $rows .= '<td><form action="?" method="post"><input type="hidden" name="action" value="undelete_session"><input type="hidden" name="session_id" value="' .$myrow['id'] .'"><input type="submit" value="Undelete"></form></td>'.PHP_EOL;
    }
        
    $rows .= '  <td><form action="?" method="post"><input type="hidden" name="action" value="move_session"><input type="hidden" name="session_id" value="' .$myrow['id'] .'"><input type="hidden" name="transaction_id" value="'. $myrow['fk_transaction'] .'">Adjust Time by: ' . DisplayAdjustor() . '</form></td>'. PHP_EOL;
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
    return '<select class="row-select" name="time_shift">'.$select.'</select> <button class="adjust-time">Go</button>'.PHP_EOL; 
}

function MoveSession($session_id, $transaction_id, $time_shift) {
    list($action, $hms) = split(" ", $time_shift);
    $q1 = 'UPDATE `session` SET `start` = '.$action.' (`start`, "'.$hms.'"), `end` = '.$action.'(`end`, "'.$hms.'") WHERE `id` = "'.$session_id.'"';
    $q2 = 'UPDATE `transaction` SET `start` = '.$action.' (`start`, "'.$hms.'"), `end` = '.$action.'(`end`, "'.$hms.'") WHERE `id` = "'.$transaction_id.'"';
    $q3 = 'UPDATE `count` SET `occurrence` = '.$action.' (`occurrence`, "'.$hms.'") WHERE `fk_session` = "'.$session_id.'"';
    $queries = array ($q1,$q2,$q3);
    foreach ($queries as $q) {
        if (mysql_query($q)) {
            print '<li>SUCCESS: '.$q.'</li>'.PHP_EOL;
        }
        else {
            print '<li>FAILED TO EXECUTE: '. $q .'</li>'.PHP_EOL;
        }   
    }
}


function DeleteUndelete($action, $id) {
    if ($action == "delete") { $dvalue = 1; }
    elseif ($action == "undelete") { $dvalue = 0; }
    $q = 'UPDATE session SET `deleted` = '.$dvalue.' WHERE `id` = "'.$id.'"';

    if (mysql_query($q)) {
        print '<p>SUCCESS: '.$q.'</p>'.PHP_EOL;
    }
    else {
        print '<p>FAILED TO EXECUTE: '. $q .'</p>'.PHP_EOL;
    }
} //end function DeleteUndelete
?>