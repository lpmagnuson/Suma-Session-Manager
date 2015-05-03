<? 
session_start(); 
include ("config.php");
require ("andwhere.class.php");
include ("scripts.php");

if (DEBUG === true) {
  error_reporting(E_WARN);
  ini_set("display_errors", true);

    var_dump($_REQUEST);
        print "<p></p>".PHP_EOL;
}

if (isset($_REQUEST['set_init'])) {
    $_SESSION['current_init'] = $_REQUEST['set_init'];
}

if (! isset($ui_theme)) { $ui_theme="cupertino"; }

?>
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
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/<? echo $ui_theme;?>/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" type="text/css" />

<script type="text/javascript">
     $(document).ready(function() {
             $('#tabs').tabs();
             $('#initiative-selector').change(function() {
                     var init = $(this).val();
                     window.location.replace('?set_init='+init);
                 });
             $( "#dp-text").click(function() {
                     $('#datepicker').datepicker('show');
                 });
             $( "#datepicker" ).datepicker({
                 showOn: "button",
                         buttonImageOnly: true,
                         buttonText: " ",
                         dateFormat: "yy-mm-dd",
                         altField: '#date-search',
                         onSelect: function() {
                         $('#date-select-form').submit();
                     }

                         });
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
             $('#suma-day-link').click(function() {
                     var link = $(this).data('url');
                     window.open(link, "SumaReport");
                 });
         });
</script>
</head>
<body>
<div id="wrapper">
<div id="content">
<h1>Suma Session Manager</h1>
<?

if (! is_readable("config.php")) {
    print '<div class="alert"><h3>Config file not readable</h3><p>The file <strong>config.php</strong> is not present or not readable. Please copy the file <strong>config-sample.php</strong> to <strong>config.php</strong> and add your local Suma Server URL to activate this service.</p></div>';
}
elseif (! defined('SUMASERVER_URL') || (SUMASERVER_URL == "")){
    print '<div class="alert"><h3>SUMASERVER_URL not set</h3><p>The <strong>SUMASERVER_URL</strong> constant in <strong>config.php</strong> is not set. Please set this constant in order to use the service.</p></div>.';
}
else {
    if (isset($default_init) &! isset ($_SESSION['current_init'])) {
        $_SESSION['current_init'] = $default_init;
    }
    print(SelectInitiative($_SESSION['current_init']));
}


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
    //    $and_where = "AND `start` LIKE '".$_REQUEST['date_search']."%'";
    $and_where = new AndWherePDO();
    $and_where->AddCondition('start',$_REQUEST['date_search'].'%','LIKE');
}
?>

<div id="tabs">
 <ul>
  <li><a href="#tabs-sessions">Sessions</a></li>
    <?
    if (in_array($_SESSION['current_init'], $one_per_hour_inits)) {
        print '<li><a href="#tabs-multi">Hours with Multiple Sessions</a></li>'.PHP_EOL;
    }
?>
 <li><a href="#tabs-readme">Documentation</a></li>
 </ul>

 <div id="tabs-sessions">
<?
    ShowEntries ($_SESSION['current_init'], $offset, $entries_per_page, $and_where, $_REQUEST['hour_focus']);        
?>
 </div><!--id=tabs-sessions-->


<?
    if (in_array($_SESSION['current_init'], $one_per_hour_inits)) {
        print '  <div id="tabs-multi">'.PHP_EOL;
        ShowMultiHours($_SESSION['current_init']);
        print '  </div><!--id=tabs-multi-->'.PHP_EOL;
    }

//print README file in Documentation Tab
print '<div id="tabs-readme">'.PHP_EOL;
$file = file_get_contents("README.md");
// crop the first line out so we can use customized header
$lines = explode("\n", $file);
$file = implode("\n", array_slice($lines, 2));
print (RenderMarkdown($file));
print '</div><!--id=readme-->'.PHP_EOL;

print ' </div><!--id=tabs-->'.PHP_EOL;
print "</div><!--id=content-->\n";

print '<div id="footer">';
include("license.php");
print "</div><!--id=footer-->\n";
print "</div><!--id=wrapper-->\n";

?>

</body>
