<?php
error_reporting(7);
// ******************** Database Setup ********************
$dbuser     = "root";              							// Database username
$dbpassword = "";               						// Database password
$dbdatabase = "onlinetest";       						// Database name
$db_prefix  = "test_";									// Database tablename prefix
///////////
$settings=array(
    'sitename'   =>'PastiNyala ELesson',
	'copyright'=>'Copyright &copy; 2014-'.date("Y").' Liew Kit Loong email:xia0t99@gmail.com',
	'timeoffset' => 8,
	'datetimeformat' => 'Y.m.d H:i',
	'dateformat' => 'YYmMdD',
	'timeformat' => 'HHiM',
    'adminout'=>'300',
	'pagenum' => 10,

	'rstime' => 3,

	'adminnum' => 20,
	'adminout' => 1000,

	'allimgwidth' => 640,

	'mfrcols' => 5,
	'mfrrows' => 5,

	'lognum' => 20,

	'logowidth'=> 88,
	'logoheight'=> 31,

	'mainwidth' => '100%',
	'mainbgcolor' => '#9EB6D8',

	'bordercolor' => '#698CC3',
	'borderbgcolor' => '#D6E0EF',

	'headercolor' => '#FFFFFF',
	'headerbgcolor' => '#698CC3',

	'titlecolor' => '#000000',
	'titlebgcolor' => '#EFEFEF',

	'altbgcolor1' => '#FFFFFF',
	'altbgcolor2' => '#EEEEEE',
	'altbgcolor3' => '#8BAEE5',

);

?>
