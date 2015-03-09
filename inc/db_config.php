<?php
<<<<<<< HEAD
=======


>>>>>>> origin/kit
$link=mysql_connect("localhost","root","");
if(!$link){
 die ("Could not connect to MySQL");
}
$select_db = mysql_select_db('elesson');
//mysql_select_db("elesson",$link) or die ("Could not open database".mysql_error());
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}
?>