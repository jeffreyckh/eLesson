<?php
ob_start();
$time_start=getmicrotime();
require "config.php";
require "db_mysql.php";
// Initiate Database
$db=new db_sql;
$db->database=$dbdatabase;
$db->user=$dbuser;
$db->password=$dbpassword;
$db->connect();
$db->select_db();

$action=(empty($_REQUEST['action'])) ? '' : $_REQUEST['action'];
$page=(empty($_REQUEST['page'])) ? '1' : intval($_REQUEST['page']);
//$selfurl=$_SERVER['PHP_SELF'];
//$referurl=$_SERVER['HTTP_REFERER'];


// Validate
function islogin(){
	global $db,$db_prefix,$selfurl;
	
	$message="";
	if (empty($_COOKIE['adminname'])||empty($_COOKIE['adminpassword'])){
		$message='Please login to Manage Center!';
	}else{
		$row=$db->query_first("SELECT password FROM ".$db_prefix."admin WHERE adminname='".$_COOKIE["adminname"]."'");
		if ($row['password']!=$_COOKIE['adminpassword']){
			$message="Wrong Password!";
		}
	}
    
	if (!empty($message)){
		setcookie("adminid",NULL);
		setcookie("adminname",NULL);
		setcookie("adminpassword",NULL);
		require "../inc/header.php";
		msg($message,"admin_test.php");
		echo "</body>\n</html>";
		exit;
	}
}
function sql($string) {
	return addslashes(trim($string));
}

function getrowbg() {

        global $bgcounter;
        if ($bgcounter++%2==0) {
           return "firstalt";
        } else {
           return "secondalt";
        }
}

// Navigation bar
function nav($message){
	global $settings;
	echo "<img src=\"images/rowspace.gif\" border=\"0\"><br>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"$settings[mainwidth]\" background=\"images/back01.gif\" height=\"24\">\n\t<tr>\n\t\t<td><nobr>&nbsp;$message</nobr></td>\n\t</tr>\n</table>\n<img src=\"images/rowspace.gif\" border=\"0\"><br>\n";
}

// Notification
function msg($message,$url){
	global $settings;
	echo "<meta http-equiv=\"refresh\" content=\"$settings[rstime];url=$url\">\n<br><br>\n<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"60%\" style=\"border: 1px solid $settings[bordercolor]\" bgcolor=\"$settings[borderbgcolor]\">\n\t<tr>\n\t\t<td align=\"center\" bgcolor=\"$settings[headerbgcolor]\"><font color=\"$settings[headercolor]\"><b>Notify Message</b></font></td>\n\t</tr>\n\t<tr>\n\t\t<td bgcolor=\"$settings[altbgcolor1]\"><br>¡¡¡¡$message<br><br></td>\n\t</tr>\n\t<tr>\n\t\t<td align=\"center\" bgcolor=\"$settings[altbgcolor2]\">$settings[rstime] second after auto refresh or <a href=\"$url\">Click Here</a> . </td>\n\t</tr>\n</table>\n<br><br>\n";
}


function maketablev($header,$titles,$contstr,$footer=array(),$cellspacing=1,$cellpadding=4){
	global $settings;

	$colspan=$header[1];
	$colspanstr="colspan=\"$colspan\"";

	if (!empty($header[2])){
		$settings['mainwidth']=$header[2];
	}

	echo "<table border=\"0\" cellspacing=\"$cellspacing\" cellpadding=\"$cellpadding\" width=\"$settings[mainwidth]\" style=\"border: 1px solid $settings[bordercolor]\" bgcolor=\"$settings[borderbgcolor]\">\n";

	if (!empty($header[0])){
		echo "\t<tr>\n\t\t<td $colspanstr height=\"24\" align=\"center\" bgcolor=\"$settings[headerbgcolor]\"><nobr><b><font color=\"$settings[headercolor]\">$header[0]</font></b></nobr></td>\n\t</tr>\n";
	}

	if (!empty($titles)){
		echo "\t<tr>\n";
		foreach ($titles as $value) {
			echo "\t\t<td align=\"center\" bgcolor=\"$settings[titlebgcolor]\"><nobr><font color=\"$settings[titlecolor]\">$value</font></nobr></td>\n";
		}
		echo "\t</tr>\n";
	}

	if (!empty($contstr)){
		$i=0;
		$j=1;
		foreach ($contstr as $value) {
			if ($j==1) echo "\t<tr>\n";
			$cont=($i/2==(int)($i/2)) ? $settings['altbgcolor1'] : $settings['altbgcolor2'];
			echo "\t\t<td ".(empty($value[2]) ? "" : "width=\"$value[2]\" ").(empty($value[1]) ? "" : "align=\"$value[1]\" ")."bgcolor=\"$cont\">$value[0]</td>\n";
			$j++;
			if ($j>$colspan){
				echo "\t</tr>\n";
				$i++;
				$j=1;
			}
		}
	}

	if (!empty($footer)){
		echo "\t<tr>\n\t\t<td $colspanstr ".(empty($footer[1]) ? "" : "align=\"$footer[1]\" ")."bgcolor=\"$settings[altbgcolor3]\">$footer[0]</td>\n\t</tr>\n";
	}

	echo "</table>\n<img src=\"images/rowspace.gif\" border=\"0\"><br>\n";

}

function makeselect($name,$cell=array(),$ed="",$explain="",$size=1,$extra=false){
	$ed=explode(",",$ed);

	$temp="\n".(empty($explain) ? "" : $explain." ")."<select $extra name=\"$name\" size=\"$size\"".($size>1 ? " multiple" : "").">";
	foreach ($cell as $value) {
		$selected=(in_array($value[0],$ed)) ? " selected" : "";
		$temp.="\n<option value=\"$value[0]\"$selected>".(empty($value[1]) ? $value[0] :$value[1])."</option>";
	}
	$temp.="\n</select>";
	return $temp;
}

function maketextarea($name,$textarea="",$cols=80,$rows=5,$extra=false){
	return "<textarea name=\"$name\" cols=\"$cols\" rows=\"$rows\" $extra>$textarea</textarea>";
}

function makeinput($type,$name,$cell=array(),$ed="",$extra=""){
	$ed=explode(",",$ed);
	$temp="";

	switch($type){
	case "text" :
		return "<input type=\"text\" name=\"$name\" value=\"".(empty($cell[0]) ? "" : $cell[0])."\"".(empty($cell[1]) ? "" : " size=\"$cell[1]\"")."  $extra>".(empty($cell[2]) ? "" : " $cell[2]");
		break;
	case "password" :
		return "<input type=\"password\" name=\"$name\" value=\"".(empty($cell[0]) ? "" : $cell[0])."\"".(empty($cell[1]) ? "" : " size=\"$cell[1]\"")." $extra>".(empty($cell[2]) ? "" : " $cell[2]");
		break;
	case "radio" :
		foreach ($cell as $value) {
			$checked=(in_array($value[0],$ed)) ? " checked" : "";
			$temp.="\n<nobr><input type=\"radio\" name=\"$name\" value=\"$value[0]\"$checked $extra>".(empty($value[1]) ? $value[0] : $value[1])."</nobr>";
		}
		break;
	case "checkbox" :
		foreach ($cell as $value) {
			$checked=(in_array($value[0],$ed)) ? " checked" : "";
			$temp.="\n<nobr><input type=\"checkbox\" name=\"$name\" value=\"$value[0]\"$checked $extra>".(empty($value[1]) ? $value[0] : $value[1])."</nobr>";
		}
		break;
	case "hidden" :
		return "<input type=\"hidden\" name=\"$name\" value=\"$cell\">";
		break;
	case "file" :
		return "<input type=\"file\" name=\"$name\" size=\"$cell\"  $extra>";
		break;
	}
	return $temp;
}


function makepage($totalnum,$pernum,$url=''){
	global $settings,$selfurl,$page;
	if ($page<1) $page=1;
	if ((($totalnum/$pernum)-((int)($totalnum/$pernum)))==0){
		$pagecount=$totalnum/$pernum;
	}else{
		$pagecount=(int)($totalnum/$pernum)+1;
	}
	if ($page>$pagecount) $page=$pagecount;
	$start=($page-1)*$pernum;
	$pagestart=(int)($page/$settings['pagenum'])*$settings['pagenum']+1;
	if ((($page % $settings['pagenum'])==0)&&((int)($page/$settings['pagenum'])>0)) $pagestart=((int)($page/$settings['pagenum'])-1)*$settings['pagenum']+1;
	$pageend=$pagestart+$settings['pagenum']-1;
	if ($pageend>$pagecount) $pageend=$pagecount;
	$temp=' ';
	for ($i=$pagestart;$i<=$pageend;$i++){
		if ($i==$page){
			$temp.='<font class="empha">'.$i.'</font> ';
		}else{
			$temp.='<a href="'.$selfurl.'?page='.$i.$url.'">'.$i.'</a> ';
		}
	}
	if ($temp==' ') $temp='0';
	return array($page,$start,'Every page '.$pernum.' List, '.$page.' page [ <a href="'.$selfurl.'?page=1'.$url.'" title="Home" ><img src="images/nav01.gif" border="0"></a><a href="'.$selfurl.'?page='.($page-$settings['pagenum']).$url.'" title="Previous'.$settings['pagenum'].'Page"><img src="images/nav02.gif" border="0"></a><a href="'.$selfurl.'?page='.($page-1).$url.'" title="Previous Page"><img src="images/nav03.gif" border="0"></a>'.$temp.'<a href="'.$selfurl.'?page='.($page+1).$url.'" title="Next Page"><img src="images/nav04.gif" border="0"></a><a href="'.$selfurl.'?page='.($page+$settings['pagenum']).$url.'" title="Next'.$settings['pagenum'].'Page"><img src="images/nav05.gif" border="0"></a><a href="'.$selfurl.'?page='.$pagecount.$url.'" title="Last Page"><img src="images/nav06.gif" border="0"></a></font> ] Total '.$pagecount.' Page, Total '.$totalnum.' List');

}
// Date Time
function maketime($timestamp,$type="datetime"){
	global $settings;
	if ($timestamp==0) return;
	if ($type=="alltime") return gmdate("Y.m.d H:i:s",$timestamp+($settings["timeoffset"]*3600));
	if ($type=="datetime") return gmdate($settings["datetimeformat"],$timestamp+($settings["timeoffset"]*3600));
	if ($type=="date") return gmdate($settings["dateformat"],$timestamp+($settings["timeoffset"]*3600));
	if ($type=="time") return gmdate($settings["timeformat"],$timestamp+($settings["timeoffset"]*3600));
}



function getmicrotime(){
	list($usec,$sec)=explode(" ",microtime());
	return ((float)$usec+(float)$sec)*1000;
}

function dooutput($text) {
         echo $text;
}


// Get html Template
function gettemplate($templatename) {
	global $settings,$url;

	$templatename="./templates/".$templatename.".html";

	$handle=fopen ($templatename, "r");
	$template=fread($handle, filesize($templatename));
	fclose($handle);

	$template = str_replace("\\'","'",addslashes($template));

	return $template;
}

?>