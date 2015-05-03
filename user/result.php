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
  
   //$keys=array_keys($_POST);
   //$order=join(",",$keys);
   
   //$query="select * from questions id IN($order) ORDER BY FIELD(id,$order)";
  // echo $query;exit;
   
   $response=mysql_query("select questionid,answer from user_to_question where userid = $uid and quizid = $qid")   or die(mysql_error());
   
   while($result=mysql_fetch_object($response)){
    $userans[] = $result->answer;
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
               //echo $result['answer'];
           }
    $score = ($right_answer/$usercount) * 100;
   }

         
          
       

   
?>
<!DOCTYPE html>
<html>
    <head>

        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/style.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="../../assets/js/html5shiv.js"></script>
        <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <header>
        </header>
        <div class="container result">
            <div class="row"> 
                    <div class='result-logo'>
                            <img src="image/Quiz_result.png" class="img-responsive"/>
                    </div>    
           </div>  
           <hr>   
           
                  
                  <div class="col-xs-6 col-sm-3 col-lg-3"> 
                     <a href="userHome.php" class='btn btn-success'>Back</a>                   
                     <a href="../login.php" class='btn btn-success'>Logout</a>
                   
                       <div style="margin-top: 30%">
                        <p>Total no. of right answers : <span class="answer"><?php echo $right_answer;?></span></p>
                        <p>Total no. of wrong answers : <span class="answer"><?php echo $wrong_answer;?></span></p>
                        <p>Total no. of Unanswered Questions : <span class="answer"><?php echo $unanswered;?></span></p>
                        <p>Score : <span class="answer"><?php echo $score;?></span></p>
                        <?php if($score < 50)
                        {
                          ?>
                          <p> you failed </p>
                          <?php
                          mysql_query(" UPDATE passingrate SET fail = fail + 1 WHERE prid = '1'");

                        }
                        else
                        {
                          ?>
                          <p> you passed </p>
                          <?php

                          mysql_query(" UPDATE passingrate SET pass = pass + 1 WHERE prid = '1'");
            

            
                            $lessonquery    = mysql_query("SELECT lessonid FROM quiz WHERE quizid = $qid",$link);
                            $done_lessonid  = mysql_result($lessonquery,0);
                            $coursequery    = mysql_query("SELECT direction_id FROM lesson WHERE lessonid = $done_lessonid",$link);
                            $done_courseid  = mysql_result($coursequery,0);       

                            $date         = date('Y-m-d H:i:s');
                            $done_query   = "SELECT lessoncount FROM lessonstatus WHERE userid = $uid AND courseid = $done_courseid";
                            $done_result  = mysql_query($done_query,$link);
                            $newlc        = mysql_result($done_result,0) + 1;
                            $sql          = "UPDATE lessonstatus SET lessoncount = $newlc WHERE userid = $uid AND courseid = $done_courseid";
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
        <footer>
        
        </footer>
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

