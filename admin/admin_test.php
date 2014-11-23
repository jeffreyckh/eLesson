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
<frameset rows="22,*" framespacing="1">
	<frame src="admin_test.php?action=top" name="head" noresize scrolling="no" frameborder="0">
	<frameset cols="140,*" framespacing="0">
		<frame src="admin_test.php?action=menu" name="menu" scrolling="yes" frameborder="0">
		<frame src="admin_test.php?action=main" name="main" scrolling="yes" frameborder="0">
	</frameset>
</frameset><noframes></noframes>
</html>
<?php
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

if ($action=="top"){
?>
<html>
<head>
<title><?php echo $settings['sitename']." - Manage Center";?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body bgcolor="#698CC3" style="margin:0px">
<center>
<table border="0" cellspacing="0" cellpadding="3" width="100%">
	<tr>
		<td width="50%" align="left">&nbsp;&nbsp;eLesson Test</td>
	</tr>
</table>
</body>
</html>
<?php
}

if ($action=="main"){
	require "../inc/header.php";
	$contstr=array();
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
	maketablev(array('Server Info',4),array(),$contstr);
	require "footer.php";
}

if ($action=="menu"){
	$contstr=array();
	$contstr[]=array('<font class="empha">'.$_COOKIE['adminname'].'</font>','center');
	$header=array("User",1);
	$titles=array();
	maketablev($header,$titles,$contstr);
	
	
	  $contstr=array();
	  $contstr[]=array(
			'<font class="menu"><a href="test_thread.php?action=edit" target="main">Test List</a></font><br>'.
			'<font class="menu"><a href="test_thread.php?action=add" target="main">Add Test</a></font><br>'.
			'<font class="menu"><a href="test_thread.php?action=setmark" target="main">Mark Setup</a></font><br>'
			,"left");
	  $header=array('Test Manage',1);
	  $titles=array();
	  maketablev($header,$titles,$contstr);

	  $contstr=array();
	  $contstr[]=array(
			'<font class="menu"><a href="admin_test.php?action=logout" target="main">Exit</a></font><br>'
			,"left");
	  $header=array('Exit',1);
	  $titles=array();
	  maketablev($header,$titles,$contstr);
	echo "</body>\n</html>";
}
?>

