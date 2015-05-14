<?php
session_start();
include'../inc/db_config.php';
$quesid = $_POST['list'];
$quizid = $_POST['quizid'];

/*$flag  = false;
    $check = "SELECT * from quiz_to_question where quizid=$quizid";
    $check_result  = mysql_query($check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(isset($quesid)){
                if(strcmp($quesid,$result_rows->questionid)!=0)
                $flag=false;
                else
                $flag=true;
            }
        }
    
    if($flag==false)
    {*/
        $delete = "DELETE from quiz_to_question WHERE quizid=$quizid";
        mysql_query($delete);
        $insert_query = "";
        
        if(isset($quesid)){

           $insert_query = "INSERT into quiz_to_question(quizid, questionid) VALUES";
            foreach( $_POST['list'] as $selected){
                echo $selected."<br>";

                $insert_query .= "('$quizid', '$selected'),";
                                    // echo $insert_query."<br>";
            }
            
            $insert_query = chop($insert_query, ",");
            if(!mysql_query($insert_query,$link)){
             die("Could not select the question.".mysql_error());
            }else
            {
                //echo '<script> alert("Select Question Successful!") </script>';
                //echo '<script language="JavaScript"> window.location.href ="view_question.php?qid='.$quizid.'"</script>';
            }
            
        }else{
            echo '<script language="JavaScript"> window.location.href ="view_question.php?qid='.$quizid.'"</script>';
        }
            // $sql="INSERT into quiz_to_question(quizid,questionid) 
            //         values('$add_quizid','$add_questionid')";
            
            
        
       
    //}
    //else{
    //    echo "Question exsited in this quiz";
   // }


  ?>