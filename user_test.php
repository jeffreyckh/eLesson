<?php
set_include_path('.' . PATH_SEPARATOR . './admin'. PATH_SEPARATOR . get_include_path());

include("global.php");

$tests = $db->query("SELECT id,name FROM ".$db_prefix."thread WHERE 1");
$test_listbit = '';
while($row = $db->fetch_array($tests)){
     eval("\$test_listbit .= \"".gettemplate("test_threadlistbit")."\";");      
}
eval("\$test_list = \"".gettemplate("test_threadlist")."\";");


eval("\$header = \"".gettemplate("test_header")."\";");
eval("\$footer = \"".gettemplate("test_footer")."\";");

eval("dooutput(\"".gettemplate("test_home")."\");");
?>
