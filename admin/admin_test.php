
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Quiz</title>
  <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
  <link rel="shortcut icon" type="image/x-icon" href="http://www.datapuri.com/CTOS/favicon.ico">
</head>
<?php
require "global.php";

/**if (empty($_COOKIE['adminname'])&&empty($action)){
	$action="logon";
}**/

if (empty($action)){
	$action="frames";
}

/**if ($action=="logon"){
	require "../inc/header.php";
	echo "<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>";
	$contstr=array();
	$contstr[]=array('Username','center','30%');
	$contstr[]=array('<input type="text" name="i_adminname" size="25" maxlength="20" value="">','left','35%');
	$contstr[]=array('Password','center');
	$contstr[]=array('<input type="password" name="i_password" size="25" maxlength="20">','left');

	$header=array('Login',2,'260');
	$titles=array();
	$footer=array('<input type="submit" value=" Login "> <input type="reset" value=" Retry ">','center');

	echo "<script language=\"javascript\">function check(){if (!document.iform.i_adminname.value||!document.iform.i_password.value){alert(\"Username and password cannot be empty£¡\");return false;}}</script><form action=\"$selfurl\" method=\"post\" name=\"iform\" onsubmit=\"return check()\"><input type=\"hidden\" name=\"action\" value=\"login\">";
	maketablev($header,$titles,$contstr,$footer);
	echo "</form>";
	echo "</body>\n</html>";
}**/

if ($action=="frames"){
?>
<html>
<head>
<title><?php echo $settings['sitename']." -Manage Center";?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../jcss/default.css" type="text/css">
</head>
<frameset rows="70,*" framespacing="1">
	<frame src="admin_test.php?action=top" name="head" noresize scrolling="no" frameborder="0">
	<frameset cols="140,*" framespacing="0">
		<frame src="admin_test.php?action=menu" name="menu" scrolling="yes" frameborder="0">
		<frame src="admin_test.php?action=main" name="main" scrolling="yes" frameborder="0">
	</frameset>
</frameset><noframes></noframes>
</html>
<?php
}
if($action == "top")
{
	include '../inc/header.php';
}
/**if ($action=="login"){
	$i_adminname=sql($_REQUEST['i_adminname']);
	$i_password=sql($_REQUEST['i_password']);
	$row=$db->query_first("SELECT adminid,adminname,password FROM ".$db_prefix."admin WHERE adminname='$i_adminname'");
	if ($row){
		if ($row['password']!=md5($i_password)){
			$message="Invalid Password£¡";
		}else{
			setcookie("adminid",$row['adminid']);
			setcookie("adminname",trim($i_adminname));
			setcookie("adminpassword",md5($i_password));
			$message="Login success£¡";
		}
	}else{
		$message="Admin¡°<font class=\"empha\">$i_adminname</font>¡± not exist£¡";
	}
	require "../inc/header.php";
	msg($message,"admin_test.php");
	echo "</body>\n</html>";
}

if ($action=="logout"){
	setcookie("adminname",NULL);
	require "../inc/header.php";
	msg("Logged out","admin_test.php");
	echo "</body>\n</html>";
}**/

?>

<?php

if ($action=="main"){
	require "header.php";
	/*$contstr=array();
	$contstr[]=array('WWW Server','center','15%');
	$contstr[]=array($_SERVER['SERVER_SOFTWARE'],'left','35%');
	$contstr[]=array('Server name','center','15%');
	$contstr[]=array($_SERVER['SERVER_NAME'],'left','35%');
	$contstr[]=array('PHP version','center');
	$contstr[]=array(phpversion(),'left');
	$contstr[]=array('Zend version','center');
	$contstr[]=array(zend_version(),'left');
	$contstr[]=array('MySQL server version','center');
	$contstr[]=array(mysql_get_server_info(),'left');
	$contstr[]=array('MySQL client version','center');
	$contstr[]=array(mysql_get_client_info(),'left');
	maketablev(array('Server Info',4),array(),$contstr);*/
	 echo "<table class=\"tableoutline\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" align=\"center\">
               <tr class=\"tbhead\">
                <td>#ID</td>
				<td>Test name </td>
                <td> date </td>
				<td> Operation </td>
               </tr>\n";

    $q= $db->query("SELECT * FROM ".$db_prefix."thread ORDER BY id DESC");
    while($title=$db->fetch_array($q)){
          echo "<tr class=".getrowbg().">
                <td>$title[id]</td>
				<td><a href='test_title.php?action=edit&threadid=$title[id]' title='Examine test quiz'>$title[name]</a></td>
                <td>".maketime($title[date],'datetime')."</td>
				<td><a href='test_title.php?action=add&threadid=$title[id]'>Add Quiz</a> <a href='".$_SERVER['PHP_SELF']."?action=mod&id=$title[id]'>Modify</a> <a href='".$_SERVER['PHP_SELF']."?action=kill&id=$title[id]'>Delete</a></td>
               </tr>\n";
           }
}

if ($action=="menu"){
	
	  $contstr=array();
	  $contstr[]=array(
			'<font class="menu"><a href="admin_test.php?action=main" target="main">Home</a></font><br>'.
			'<font class="menu"><a href="test_thread.php?action=edit" target="main">Test List</a></font><br>'.
			'<font class="menu"><a href="test_thread.php?action=add" target="main">Add Test</a></font><br>'.
			'<font class="menu"><a href="test_thread.php?action=setmark" target="main">Mark Setup</a></font><br>'
			,"left");
	  $header=array('Test Manage',1);
	  $titles=array();
	  maketablev($header,$titles,$contstr);

	echo "</body>\n</html>";
}
?>

