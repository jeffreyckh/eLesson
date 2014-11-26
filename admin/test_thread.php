<?php
require "global.php";
require "forms.php";
require "php_pagenav_class.php";
$cpforms = new FORMS;
require "header.php";
//islogin();

if ($action=="edit")  {

    echo "<table class=\"tableoutline\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" align=\"center\">
               <tr class=\"tbhead\">
                <td>ID</td>
				        <td>Quiz </td>
                <td> Date </td>
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

    echo "<tr class=tbcat>
            <td colspan=\"4\" align=\"center\"> </td>\n</tr>\n</table>\n";

}
if ($action=="add")  {

    $cpforms->formheader(array('title'=>'Add Quiz'));
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'insert'));

    $cpforms->makeinput(array('text'=>'Quiz Name:',
                               'name'=>'name'));
	$cpforms->formfooter();
}


if ($_POST[action]=="insert"){

    $name = htmlspecialchars(trim($_POST[name]));
	if(!$name){
	    msg("Quiz cannot be empty",$_SERVER['PHP_SELF']."?action=add");
		exit;
	}
    $db->query("INSERT INTO ".$db_prefix."thread(name,date) VALUES ('".addslashes($name)."','".time()."')");
    $id = $db->insert_id();
    msg("New quiz has been added,please add the questions of this quiz. <a href=\"test_title.php?action=add&threadid=$id\">Add Question</a>","./test_title.php?action=add&threadid=$id");

}



if ($action=="mod")  {

    $id = intval($_GET[id]);
	$title = $db->fetch_one_array("SELECT * FROM ".$db_prefix."thread WHERE id=$id");
    $cpforms->formheader(array('title'=>'Modify Quiz'));
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'update'));
    $cpforms->makehidden(array('name'=>'id',
                                'value'=>$id));

    $cpforms->makeinput(array('text'=>'Quiz Name:',
                               'name'=>'name',
							   'value'=>$title[name]));
	$cpforms->formfooter();

}



if ($_POST[action]=="update"){

    $id = intval($_POST[id]);
	$name = htmlspecialchars(trim($_POST[name]));

    $db->query("UPDATE ".$db_prefix."thread SET name='".addslashes($name)."' WHERE id=$id");
    
    msg("Quiz has been updated","./test_thread.php?action=edit");


}


if ($_GET[action]=="kill"){

    $id = intval($_GET[id]);
    $cpforms->formheader(array('title'=>'Confirm to delete the Quiz?Questions of the quiz will been delete also.'));
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'remove'));
    $cpforms->makehidden(array('name'=>'id',
                                'value'=>$id));

    $cpforms->formfooter(array('confirm'=>1));

}



if ($_POST[action]=="remove"){

    $id = intval($_POST[id]);
    
    //Delete all options
	$q = $db->query("SELECT id FROM ".$db_prefix."title WHERE threadid='$id'");
	while($r=$db->fetch_array($q)){
	      $db->query("DELETE FROM ".$db_prefix."choice WHERE  extends=$r[id]");
	}
	//Delete all quiz
    $db->query("DELETE FROM ".$db_prefix."title WHERE threadid =$id");

	//Delete test
    $db->query("DELETE FROM ".$db_prefix."thread WHERE id =$id");

    msg("Quiz had been deleted.","./test_thread.php?action=edit");

}

////////Quiz mark setup
if($_GET[action]=="setmark"){
   $mark = $db->query_first("SELECT * FROM ".$db_prefix."setmark");

   $contstr = array();
   $contstr[] = array('Single Choice','left','10%');
   $contstr[] = array(makeinput('text','radio',array($mark[radio],'10','marks'),''),'left');
   $contstr[] = array('Multi Choice','left');
   $contstr[] = array(makeinput('text','checkbox',array($mark[checkbox],'10','marks'),''),'left');
   
   $header = array('Quiz mark setup',2);
   $titles = array();
   $footer = array('<input type="submit" name="submit" value=" Confirm ">','center');
   echo "<form name='form' action='$selfurl' method='post'><input name='action' value='dosetmark' type='hidden'>";
   maketablev($header,$titles,$contstr,$footer);
   echo "</form>";
   
}

if($_POST[action]=="dosetmark"){
   $radio = sql($_POST[radio]);
   $checkbox = sql($_POST[checkbox]);
   $db->query("UPDATE ".$db_prefix."setmark set radio='$radio',checkbox='$checkbox'");
   msg("Mark modify success.",$selfurl."?action=setmark");
}

require "footer.php";
?>