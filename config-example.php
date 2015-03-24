<?
define ("DEBUG", false); // if DEBUG==true, display mysql query strings
define ("SUMASERVER_URL", ""); // full url with no trailing slash, e.g. http://www.example.com/sumaserver, see note about sumaserver security in README.md file
define ("SUMA_REPORTS_URL", ""); // full url with no trailing slash, e.g. http://www.example.com/suma/analysis/reports, see note about sumaserver security in README.md file

$mysql_host     = "localhost";
$mysql_database = "";
$mysql_user     = "";
$mysql_password = "";

$default_init   = "";
$entries_per_page = 100;

/*
  If an initiative is intended to usually only have one count per hour, 
  include it in the $one_per_hour_inits array to allow searching on hours
  with multiple entries.
  example: $one_per_hour_inits = array(1,4);
*/

$one_per_hour_inits = array();
?>