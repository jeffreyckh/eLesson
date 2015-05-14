<?php
session_start();
 include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
?>


<?php 
    $uid = $_SESSION['userid'];
    $qid = $_SESSION['qid'];
    
    $right_answer=0;
    $wrong_answer=0;
    $unanswered=0;
    $score = 0; 
    $userans = array();
    $orians = array();
    $quesarray = array();
     $userans2 = array();
    $orians2 = array();
    $quesarray2 = array();
  
   //$keys=array_keys($_POST);
   //$order=join(",",$keys);
   
   //$query="select * from questions id IN($order) ORDER BY FIELD(id,$order)";
  // echo $query;exit;
   
   $response=mysql_query("select questionid,answer from user_to_question where userid = $uid and quizid = $qid")   or die(mysql_error());
   
   while($result=mysql_fetch_object($response)){
    $userans[] = $result->answer;
    $quesarray[] = $result ->questionid;
      $ansquery = "select answer from question where questionid = $result->questionid";
      $ansresult = mysql_query($ansquery);
      while ($ans_rows = mysql_fetch_object($ansresult)) {
        $orians[] = $ans_rows->answer;
      }
       
   }
   $usercount = count($userans);
   for($i=0;$i<$usercount;$i++)
   {
      //echo $orians[$i];
      if($userans[$i]==$orians[$i])
          {
               $right_answer++;
           }else if($userans[$i]==5){
               $unanswered++;
           }
           else{
               $wrong_answer++;
               $userans2[] = $userans[$i];
               $orians2[] = $orians[$i];
               $quesarray2[] = $quesarray[$i];
               //echo $result['answer'];
           }
    $score = ($right_answer/$usercount) * 100;
    $result = round($score);
   }

         
        $updatesql = "UPDATE user_to_quiz SET attempt = attempt + 1 WHERE userid = $uid AND quizid = $qid";
        mysql_query($updatesql);
       

   
?>
<!DOCTYPE html>
<html>
    <head>

        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
        <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
        <link href="css/style.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="style.css">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="../../assets/js/html5shiv.js"></script>
        <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <!-- <header>
        </header> -->
        
        <center>
          <a href="userHome.php" class='btn btn-success'>Back</a>                   
        <a href="../login.php" class='btn btn-success'>Logout</a>
        <br>
        <br>
      </center>
        <div id="result_container">
           <center><h3>Quiz Results</h3></center>
           <hr>   
                  <!-- <div class="col-xs-6 col-sm-3 col-lg-3">  -->
                     
                   
                       <div style="margin-top: 5%">
                        <p>Total no. of right answers : <span class="answer"><?php echo $right_answer;?></span></p>
                        <p>Total no. of wrong answers : <span class="answer"><?php echo $wrong_answer;?></span></p>
                        <p>Total no. of Unanswered Questions : <span class="answer"><?php echo $unanswered;?></span></p>
                        <p>Score : <span class="answer"><?php echo $result;?></span></p>
                        <?php 
                        $count = count($quesarray2);
                        if($count != 0)
                        {
                          for($i = 0;$i <$count;$i++)
                          {
                            $y = $i + 1;
                            echo 'No ' . $y . ' ';
                            $quesid = $quesarray[$i];
                           
                            $qcquery = mysql_query("SELECT content FROM question WHERE questionid = $quesid") or die (mysql_error());
                            $qcontent = mysql_result($qcquery,0);
                            echo $qcontent . '<br>';
                            echo 'You choose ' . $userans2[$i] . ' .Correct Answer: ' . $orians2[$i] . '<br>';

                          }

                        }

                        $scorequery = " SELECT passingscore FROM quiz WHERE quizid = $qid";
                        $scoreresult = mysql_query($scorequery);
                        $passscore = mysql_result($scoreresult, 0);
                        if($result < $passscore)
                        {
                        ?>
                          <p> Sorry! You had <font color="red"><b> FAILED </b> </font> the quiz. Please take the quiz again in order to advance to the next lesson</p>
                        <?php
                          $checkdone = mysql_query("SELECT * FROM passingrate WHERE userid = $uid AND quizid = $qid") or die(mysql_error());
                          if(mysql_num_rows($checkdone) == 0)
                          {
                            mysql_query(" INSERT INTO passingrate(userid,quizid,result,pass) VALUES ('$uid','$qid','$result','0')") or die(mysql_error());
                          }
                          else
                          {
                            mysql_query("UPDATE passingrate SET result = '$result', pass = '0' WHERE userid = $uid AND quizid = $qid") or die(mysql_error());
                          }
                        }
                        else
                        {
                        ?>
                        <p> Congratulations! You had <font color="blue"><b> PASSED </b></font> the quiz. Now you can advance to the next lesson!</p>
                        <?php

                          $checkdone = mysql_query("SELECT * FROM passingrate WHERE userid = $uid AND quizid = $qid") or die(mysql_error());
                          if(mysql_num_rows($checkdone) == 0)
                          {
                            mysql_query(" INSERT INTO passingrate(userid,quizid,result,pass) VALUES ('$uid','$qid','$result','1')") or die(mysql_error());
                          }
                          else
                          {
                            mysql_query("UPDATE passingrate SET result = '$result', pass = '1' WHERE userid = $uid AND quizid = $qid") or die(mysql_error());
                          }
          

          
                          $lessonquery = mysql_query("SELECT lessonid FROM quiz WHERE quizid = $qid",$link);
                          $done_lessonid = mysql_result($lessonquery,0);
                          $coursequery = mysql_query("SELECT direction_id FROM lesson WHERE lessonid = $done_lessonid",$link);
                          $done_courseid = mysql_result($coursequery,0);       
                          $quizquery = mysql_query("SELECT complete FROM user_to_quiz WHERE quizid = $qid AND userid = $uid");
                          $quiz_complete = mysql_result($quizquery,0);

                          $date = date('Y-m-d H:i:s');
                          $done_query="SELECT lessoncount FROM lessonstatus WHERE userid = $uid AND courseid = $done_courseid";
                          $done_result=mysql_query($done_query,$link);
                          $newlc = mysql_result($done_result,0) + 1;

                          if ($quiz_complete == 0)
                          {

                          $sql = "UPDATE lessonstatus SET lessoncount = $newlc WHERE userid = $uid AND courseid = $done_courseid";
                          }


                           if(!mysql_query($sql,$link))
                            { die("Could not update the data!".mysql_error());}
                            else
                            {
                                $sql = "UPDATE user_to_quiz SET complete = '1',finish_time= '$date' WHERE userid = $uid AND quizid = $qid";
                                if(!mysql_query($sql,$link))
                                  { die("Could not update the data!".mysql_error());}
                                   else
                                  {
                                      echo '<script> alert("You Passed.") </script>';
                              
                                  }
                              
                            }
                        }
                        ?>                   
                       </div> 
                   
                   </div>
                    
            </div>    
            <div class="row">    
                    
            </div>
        </div>
        <!-- <footer>
        
        </footer> -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/jquery.validate.min.js"></script>

        

    </body>
</html>
<?php
$delquery=mysql_query("delete from user_to_question where userid = $uid and quizid = $qid")   or die(mysql_error());
?>

