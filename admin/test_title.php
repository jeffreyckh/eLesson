<?php

require "global.php";

require "forms.php";
require "php_pagenav_class.php";
$cpforms = new FORMS;

require "header.php";

$threadid = intval($_REQUEST[threadid]);
if(!$threadid){
  msg('URL lack of thread id.','test_thread.php?action=edit');
  exit;
}else{
  $rs = $db->query_first("SELECT * FROM ".$db_prefix."thread WHERE id='$threadid'");
  if(!$rs){
     msg('No test found.','test_thread.php?action=edit');
     exit;
  }
}

$rs = $db->query_first("SELECT name FROM ".$db_prefix."thread WHERE id='$threadid'");
$cpforms->tableheader();
echo "<tr class=".getrowbg().">
          <td >
              <strong><a href='test_title.php?action=edit&threadid=$threadid'>$rs[name]</a></strong>
          </td>
          <td  align=right>
             <a href='test_title.php?action=add&threadid=$threadid'>Add new test</a>
          </td>
        </tr>";
$cpforms->tablefooter();
echo "<br>";

if ($action=="edit")  {
   

    echo "<table class=\"tableoutline\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" align=\"center\">
               <tr class=\"tbhead\">
                <td>#ID</td>
				<td nowrap width=\"50%\"> Title </td>
                <td nowrap align=\"center\"> Option </td>
				 <td nowrap align=\"center\"> Option type </td>
                <td nowrap align=\"center\"> Operation </td>
               </tr>\n";

    $q= $db->query("SELECT * FROM ".$db_prefix."title WHERE threadid='$threadid' ORDER BY id DESC");
    while($title=$db->fetch_array($q)){
	      switch($title[choicetype]){
		         case "radio":   $choicetype="Single choice";$prehref="test_show.php?id=$title[id]";break;
				 case "checkbox":$choicetype="Multi choice";$prehref="test_show.php?id=$title[id]";break;
		  }
          echo "<tr class=".getrowbg().">
                <td>$title[id]</td>
				<td width=\"50%\">$title[title]</td>
                <td align=\"center\"> <a href=\"test_choice.php?action=add&threadid=$threadid&id=$title[id]\">New Option</a> </td>
                <td align=\"center\"> $choicetype </td>
                <td align=\"center\"> <a href=\"test_title.php?action=mod&threadid=$threadid&id=$title[id]\">Modify</a> <a href=\"test_title.php?action=kill&threadid=$threadid&id=$title[id]\">Delete</a> </td>
               </tr>\n";
   
   }


    echo "<tr class=tbcat>
            <td colspan=\"6\" align=\"center\"> </td>\n</tr>\n</table>\n";

}
if ($_GET[action]=="add")  {
   
   $items = array();
   $q = $db->query("SELECT id,name FROM ".$db_prefix."thread");
   while($r = $db->fetch_array($q)){
         $items[$r[id]]=$r[name];
   }
    $cpforms->formheader(array('title'=>'Add New Quiz'));
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'insert'));

    $cpforms->makeselect(array('text'=>'Select Test:',
                               'name'=>'threadid',
							   'option'=>$items,
							   'selected'=>(intval($_GET[threadid]) ? intval($_GET[threadid]) : 0)
							   ));
							   
    $cpforms->maketextarea(array('text'=>'Quiz Content:',
                               'name'=>'title'));

    $cpforms->makeselect(array('text'=>'Option Type£º',
                               'name'=>'choicetype',
                               'option'=>array('radio'=>'Single Choice','checkbox'=>'Multi Choice')
								   ));
    $cpforms->makeinput(array('text'=>'Correct answer:Multiple answer please use "," separate',
                               'name'=>'answer'));

    
	
	$cpforms->formfooter();
}


if ($_POST[action]=="insert"){

    $threadid = intval($_POST[threadid]);
    $title = htmlspecialchars(trim($_POST[title]));
    $choicetype = $_POST[choicetype];
	$answer = sql($_POST[answer]);
    $answer = str_replace(",",",",$answer);
    if(!$title || !$answer){
	   msg("Quiz content and answer cannot be empty","$selfurl?action=add");exit;
	}
	
	$db->query("INSERT INTO ".$db_prefix."title(threadid,title,choicetype,answer) VALUES ('$threadid','".addslashes($title)."','".addslashes($choicetype)."','$answer')");
    $id = $db->insert_id();
    msg("New quiz has been added, please add new option<a href=\"test_choice.php?action=add&threadid=$threadid&id=$id\">Add option</a>","./test_title.php?action=edit&threadid=$threadid");

}



if ($action=="mod")  {

    $id = intval($_GET[id]);

	$title = $db->fetch_one_array("SELECT * FROM ".$db_prefix."title WHERE id=$id");

   $items = array();
   $q = $db->query("SELECT id,name FROM ".$db_prefix."thread");
   while($r = $db->fetch_array($q)){
         $items[$r[id]]=$r[name];
   }

    $cpforms->formheader(array('title'=>'Modify Quiz'));
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'update'));

    $cpforms->makehidden(array('name'=>'id',
                                'value'=>$id));

    $cpforms->makeselect(array('text'=>'Select Test:',
                               'name'=>'threadid',
							   'option'=>$items,
							   'selected'=>$title[threadid]
							   ));
    $cpforms->maketextarea(array('text'=>'Quiz Content:',
                               'name'=>'title',
							   'value'=>$title[title]));

    $cpforms->makeselect(array('text'=>'Option Type£º',
                               'name'=>'choicetype',
                               'option'=>array('radio'=>'Single Choice','checkbox'=>'Multi Choice'),
							   'selected'=>$title[choicetype]));
								  
    $cpforms->makeinput(array('text'=>'Correct Answer:Please use "," to separate multiple answer.',
                               'name'=>'answer',
							   'value'=>$title[answer]
							   ));

	$cpforms->formfooter();

}



if ($_POST[action]=="update"){

    $id = intval($_POST[id]);
	$threadid = intval($_POST[threadid]);
	$title = htmlspecialchars(trim($_POST[title]));
    $choicetype = $_POST[choicetype];
	$answer = sql($_POST[answer]);
	$answer = str_replace(",",",",$answer);
    if(!$title || !$answer){
	   msg("Quiz title and answer cannot be empty","$selfurl?action=add");exit;
	}
	
    $db->query("UPDATE ".$db_prefix."title SET threadid='$threadid',title='".addslashes($title)."',choicetype='".addslashes($choicetype)."',answer='$answer' WHERE id=$id");
    
    msg("Quiz has been updated","./test_title.php?action=mod&threadid=$threadid&id=$id");


}


if ($_GET[action]=="kill"){

    $id = intval($_GET[id]);
	$threadid = intval($_GET[threadid]);
    $cpforms->formheader(array('title'=>'Confirm to delete the quiz?'));
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'remove'));
    $cpforms->makehidden(array('name'=>'threadid',
                                'value'=>$threadid));
    $cpforms->makehidden(array('name'=>'id',
                                'value'=>$id));

    $cpforms->formfooter(array('confirm'=>1));

}



if ($_POST[action]=="remove"){

   $threadid = intval($_POST[threadid]);
   $id = intval($_POST[id]);

    $db->query("DELETE FROM ".$db_prefix."title WHERE id =$id");
    $db->query("DELETE FROM ".$db_prefix."choice WHERE extends = $id");

    msg("Quiz has been deleted","./test_title.php?action=edit&threadid=$threadid");

}



require "footer.php";
?>