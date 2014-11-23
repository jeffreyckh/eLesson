<?php
require "global.php";
require "forms.php";
require "php_pagenav_class.php";
$cpforms = new FORMS;
require "header.php";
//islogin();


$threadid = intval($_REQUEST[threadid]);
if(!$threadid){
  msg('URL lack of thread ID.','test_thread.php?action=edit');
  exit;
}else{
  $rs = $db->query_first("SELECT * FROM ".$db_prefix."thread WHERE id='$threadid'");
  if(!$rs){
     msg('No result found.','test_thread.php?action=edit');
     exit;
  }
}

$rs = $db->query_first("SELECT name FROM ".$db_prefix."thread WHERE id='$threadid'");
$cpforms->tableheader();
echo "<tr class=".getrowbg().">
          <td >
              <strong>*<a href='test_title.php?action=edit&threadid=$threadid'>$rs[name]</a></strong>
          </td>
          <td  align=right>
             <a href='test_title.php?action=add&threadid=$threadid'>Add New Question</a>
          </td>
        </tr>";
$cpforms->tablefooter();
echo "<br>";


if ($_GET[action]=="add")  {
    $tid = intval($_GET[id]);
	$title = $db->fetch_one_array("SELECT * FROM ".$db_prefix."title WHERE id=$tid");
      echo "<table class=\"tableoutline\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" align=\"center\">
               <tr class=\"tbhead\">
                <td nowrap > Current question </td>
               </tr>
               <tr >
                <td nowrap class=".getrowbg().">$title[title]</td>
               </tr>
               <tr >
                <td nowrap align=\"right\" class=".getrowbg().">Choice: ".($title[choice] ? "Single Choice" : "Multi Choice")." <a href=\"test_title.php?action=mod&threadid=$threadid&id=$id\">Modify</a></td>
               </tr>
			   </table><br>\n";
      
    $cpforms->formheader(array('title'=>'Add new option'));
	
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'insert'));
    $cpforms->makehidden(array('name'=>'threadid',
                                'value'=>$threadid));
    $cpforms->makehidden(array('name'=>'tid',
                                'value'=>$tid));

    $cpforms->makeinput(array('text'=>'Content:',
                               'name'=>'choice'));

     $cpforms->makeyesno(array('text'=>'Is Default?','name'=>'IsDefault'));
    $cpforms->formfooter();
    echo "<br><table class=\"tableoutline\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" align=\"center\">
               <tr class=\"tbhead\">
                <td nowrap width=\"50%\"> Option List </td>
                <td nowrap align=\"center\"> Default </td>
                <td nowrap align=\"center\"> Operation </td>
               </tr>\n";

	$id = intval($_GET[id]);
    $q = $db->query("SELECT * FROM ".$db_prefix."choice WHERE extends=$id ORDER BY id DESC");
	while($choice  = $db->fetch_array($q)){
	     
          echo "<tr class=".getrowbg().">
                <td nowrap width=\"50%\">$choice[choice]</td>
                <td nowrap align=\"center\">".($choice[IsDefault] ? "Default" : "&nbsp;")."</td>
                <td nowrap align=\"center\"> <a href=\"test_choice.php?action=mod&threadid=$threadid&id=$choice[id]\">Modify</a> <a href=\"test_choice.php?action=kill&threadid=$threadid&id=$choice[id]&tid=$choice[extends]\">Delete</a> </td>
               </tr>\n";
   
   }


    echo "<tr class=tbcat>
            <td colspan=\"3\" align=\"center\"> </td>\n</tr>\n</table>\n";

}



if ($_POST[action]=="insert"){
    $threadid = intval($_POST[threadid]);
	$extends = intval($_POST[tid]);//Title id
    $choice = htmlspecialchars(trim($_POST[choice]));
    $IsDefault = $_POST[IsDefault];
    if ($choice==""){
        pa_exit("Option name cannot be empty");
    }
    if($IsDefault)
	$db->query("UPDATE ".$db_prefix."choice SET IsDefault=0 WHERE extends=$extends");
    $db->query("INSERT INTO ".$db_prefix."choice (choice,extends,IsDefault)VALUES ('".addslashes($choice)."','$extends','".addslashes($IsDefault)."')");

    msg("Option has been added","./test_choice.php?action=add&threadid=$threadid&id=$extends");

}



if ($action=="mod")  {
    
	$threadid = intval($_GET[threadid]);
	$id = intval($_GET[id]);
	$choice = $db->fetch_one_array("SELECT * FROM ".$db_prefix."choice WHERE id=$id");
    $cpforms->formheader(array('title'=>'Option modify'));
	
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'update'));
    $cpforms->makehidden(array('name'=>'threadid',
                                'value'=>$threadid));
    $cpforms->makehidden(array('name'=>'id',
                                'value'=>$id));
    $cpforms->makehidden(array('name'=>'tid',
                                'value'=>$choice['extends']));


    $cpforms->makeinput(array('text'=>'Modify Content:',
                               'name'=>'choice',
							   'value'=>$choice[choice]
							   ));

    $cpforms->makeyesno(array('text'=>'Default?','name'=>'IsDefault','selected'=>$choice[IsDefault]));
    $cpforms->formfooter(array('confirm'=>1));

}



if ($_POST[action]=="update"){
    
	$threadid = intval($_POST[threadid]);
    $extends = intval($_POST[tid]);//title id
	$id = intval($_POST[id]);//option id
    $choice = htmlspecialchars(trim($_POST[choice]));
    $IsDefault = $_POST[IsDefault];
    if ($choice==""){
        pa_exit("Option name cannot be empty");
    }
    if($IsDefault)
	$db->query("UPDATE ".$db_prefix."choice SET IsDefault=0 WHERE extends=$extends");
    $db->query("UPDATE ".$db_prefix."choice SET choice='".addslashes($choice)."',IsDefault='".addslashes($IsDefault)."'  WHERE id=$id");

    msg("Option has been edited","./test_choice.php?action=add&threadid=$threadid&id=$extends");

}


if ($_GET[action]=="kill"){
    $threadid = intval($_GET[threadid]);
    $id = intval($_GET[id]);
	$tid = intval($_GET[tid]);
    $cpforms->formheader(array('title'=>'Delete the option?'));
    $cpforms->makehidden(array('name'=>'action',
                                'value'=>'remove'));
    $cpforms->makehidden(array('name'=>'threadid',
                                'value'=>$threadid));
    $cpforms->makehidden(array('name'=>'id',
                                'value'=>$id));
    $cpforms->makehidden(array('name'=>'tid',
                                'value'=>$tid));

    $cpforms->formfooter(array('confirm'=>1));

}



if ($_POST[action]=="remove"){
    
	$threadid=$_POST[threadid];
    $id = intval($_POST[id]);
	$tid = intval($_POST[tid]);
    $db->query("DELETE FROM ".$db_prefix."choice WHERE id =$id");

    msg("Option has been deleted","./test_choice.php?action=add&threadid=$threadid&id=$tid");

}






require "footer.php";
?>