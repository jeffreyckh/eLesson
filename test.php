<?php
set_include_path('.' . PATH_SEPARATOR . './admin'. PATH_SEPARATOR . get_include_path());

include("global.php");

$threadid  = intval($_REQUEST[threadid]);


if($_POST["action"]=="dotest"){
   $_POST[radio]     = $_POST[radio]    ? $_POST[radio]    : array();
   $_POST[checkbox]  = $_POST[checkbox] ? $_POST[checkbox] : array();
   
   //Get single and multiple choice value
   $getsetmark = $db->query_first("SELECT radio,checkbox FROM ".$db_prefix."setmark");
   
   //Buffer correct answer
   $answers = $db->query("SELECT id,title,choicetype,answer FROM ".$db_prefix."title WHERE 1");
   $answer_array = array();
   $titles       = array();
   $error        = array();
   $tmark = 0;
   while($row = $db->fetch_array($answers)){
         $answer_array[$row[id]] = $row[answer];
		 $titles[$row[id]]       = $row[title];
		 if($row[choicetype]=="radio"){
		    $tmark += $getsetmark[radio];
		 }elseif($row[choicetype]=="checkbox"){
		    $tmark += $getsetmark[checkbox];
		 }
   }
   $mark = 0;
   foreach($_POST[radio] as $titleid=>$choice){
              
           if($choice == $answer_array[$titleid]){
		      $mark += $getsetmark[radio];
		   }else{
		      $error[] = array($titleid,$choice,$answer_array[$titleid]);
		   }
		   
   
   }
   

   foreach($_POST[checkbox] as $titleid=>$choice){
   
          $c_answers = explode(",",$answer_array[$titleid]);
		  $flag = false; 
		  
		  foreach($c_answers as $answer){
		          if(!in_array($answer,$choice)){
				     $flag = true;
				  }
		  }
		  foreach($choice as $answer){
		          if(!in_array($answer,$c_answers)){
				     $flag = true;
				  }
		  }
		  
		  if($flag){
		     $error[] = array($titleid,implode(",",$choice),$answer_array[$titleid]);
			 continue;
		  }
		  $mark += $getsetmark[checkbox];
   
   } 
   
   
   
   
   
   $msg = "Test Total Mark{$tmark}mark\\nYour Score{$mark}\\n";
   if($error){
      $msg .= "Question of wrong answer\\n";
	  foreach($error as $v){
	          $msg .= "{$titles[$v[0]]}\\nYour answer:{$v[1]}\\nCorrect answer:{$v[2]}\\n\\n";
	  }
   }
   echo "<script>alert('$msg');document.location.href='user_test'</script>";
   exit;
}
if(!$threadid){
   echo "parameter wrong";
   echo '<meta http-equiv="refresh" content="2; url=user_test">';
   exit;

}
//Test name
$threads = $db->query_first("SELECT name FROM ".$db_prefix."thread WHERE id=$threadid");
$threadtitle = $threads[name];


//Quiz list
$conditions = $threadid ? "threadid='$threadid'" : 1;


$titles = $db->query("SELECT * FROM ".$db_prefix."title WHERE $conditions ORDER BY id ASC");
$titlelist = false;
$int = 0;
while($title = $db->fetch_array($titles)){
      $int++;
	  $choices = false;
	  $tests = $db->query("SELECT * FROM ".$db_prefix."choice WHERE extends=$title[id] ORDER BY id ASC");
	  $i=0;
	  while($test=$db->fetch_array($tests)) {
	        $i++;
	 	    $checked = $test["IsDefault"] ? "checked" : false;   
		       
		    if($title[choicetype]=="radio"){
		  	   $choices .=  "<input name=\"radio[$title[id]]\" type=\"radio\" value=\"$test[choice]\" $checked check=\"^0$\" warning=\"$title[title]\"> $test[choice]";  //
			}else{
			   $choices .=  "<input name=\"checkbox[$title[id]][]\" type=\"checkbox\" value=\"$test[choice]\" $checked check=\"^0{1,}$\" warning=\"$title[title]\"> $test[choice]";//
			}
	  }
	  eval("\$titlelist .= \"".gettemplate("test_title_list")."\";");   
}

eval("\$header = \"".gettemplate("test_header")."\";");
eval("\$footer = \"".gettemplate("test_footer")."\";");

eval("dooutput(\"".gettemplate("test_test")."\");");

?>