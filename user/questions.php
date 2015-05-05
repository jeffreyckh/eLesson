
<?php
session_start();
   include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
?>


<?php 
  $qid = intval($_GET['qid']);
  $uid = $_SESSION['userid'];
  $_SESSION['qid'] = $qid;
        $query_count="select count(*) from question where quizid = $qid";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        $query_name = "select quizname from quiz where quizid = $qid";
        $result_name = mysql_query($query_name,$link);
        $quizname = mysql_result($result_name,0);
        $querycheck = "select * from user_to_quiz where userid = $uid and quizid = $qid";
        $checkresult = mysql_query($querycheck);

        if(mysql_num_rows($checkresult) == 0)
        {

          $starttime = date('Y-m-d H:i:s');

          $sql = "INSERT INTO  user_to_quiz (userid, quizid,complete,start_time)
            VALUES ('$uid', '$qid','0','$starttime')";
            mysql_query($sql,$link);
        }

?>
<!DOCTYPE html>
<html>
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="Conduct Quiz">
  <meta name="description" content="Conduct Quiz"> 
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
		<title>Quiz</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/style.css" rel="stylesheet" media="screen">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="../../assets/js/html5shiv.js"></script>
		<script src="../../assets/js/respond.min.js"></script>
		<![endif]-->
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.10.2.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
		<script src="js/countdown.js"></script>

	</head>
	
  <body>
	  
        <div id='timer'>
            <script type="application/javascript">
            var myCountdownTest = new Countdown({
                                    time: 1000, 
                                    width:200, 
                                    height:80, 
                                    rangeHi:"minute"
                                    });
           </script>
            
        </div>
        
		<div class="container question">
			<div class="col-xs-12 col-sm-8 col-md-8 col-xs-offset-4 col-sm-offset-3 col-md-offset-3">
				<p>
				
				</p>
				<hr>
				<form class="form-horizontal" role="form" id='login' method="post" action="result.php">
					<?php 
                    $validquery = "select * from user_to_question where userid = $uid and quizid = $qid and completed = '0'";
                    $validresult = mysql_query($validquery);
                    $vrows = mysql_num_rows($validresult);
                    $bi=1;
                    if($vrows == 0)
                    {
					            $res = mysql_query("select * from quiz_to_question where quizid = $qid ORDER BY RAND() LIMIT 3") or die(mysql_error());
                      $rows = mysql_num_rows($res);
					            $i=1;
                      while($result=mysql_fetch_object($res))
                      {
                      $uquery = "INSERT INTO user_to_question( userid, quizid, questionid,answer,completed) 
                                VALUES ('$uid', '$qid', '$result->questionid','5','0')";
                      $uresult = mysql_query($uquery);          
                      $query2 = "select * from question where questionid = $result->questionid";
                      $result2=mysql_query($query2,$link);
                      while($b_rows=mysql_fetch_object($result2))
                      {
                          $y=1;
                          $optionstring = $b_rows->optionlist;
                          $optiontoken = strtok($optionstring, "/");
      
                          if($i<=1 || $i<$rows)
                          {
                            ?>         
                          <div id='question<?php echo $i;?>' class='cont'>
                          <p class='questions' id="qname<?php echo $i;?>"> <?php echo $i?>.<?php echo $b_rows->content;?></p>
                          <?php

                          while ($optiontoken !== false)
                          {
                              $getvalue = $optiontoken;
                              $getvalue = str_replace(" ","-",$getvalue);
                          ?>
                          <input type="radio" value="<?php echo $optiontoken;?>" id='radio1_<?php echo $b_rows->questionid;?>' name='<?php echo $b_rows->questionid;?>' onclick="update(this);"/><?php echo $optiontoken;?>
                         <br/>
                             <?php $optiontoken = strtok("/"); 
                             $y++; 
                           }
                             ?>
        
                          <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $b_rows->questionid;?>' name='<?php echo $b_rows->questionid;?>'/>                                                                      
                          <br/>
                          <button id='<?php echo $i;?>' class='next btn btn-success' type='button'>Next</button>
                          </div>     
                                                          
                         <?php
                          }
                          elseif($i==$rows)
                          {
                          ?>
                          <div id='question<?php echo $i;?>' class='cont'>
                          <p class='questions' id="qname<?php echo $i;?>"> <?php echo $i?>.<?php echo $b_rows->content;?></p>
      
                          <?php
                          while ($optiontoken !== false)
                          {
                              $getvalue = $optiontoken;
                              $getvalue = str_replace(" ","-",$getvalue);
                          ?>
                          <input type="radio" value="<?php echo $optiontoken;?>" id='radio1_<?php echo $b_rows->questionid;?>' name='<?php echo $b_rows->questionid;?>' onclick="update(this);"/><?php echo $optiontoken;?>
                         <br/>
                             <?php $optiontoken = strtok("/"); 
                             $y++; 
                           }
                             ?>
                          <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $b_rows->questionid;?>' name='<?php echo $b_rows->questionid;?>'/>    
                          
                                          
                          <button id='<?php echo $i;?>' class='next btn btn-success' type='submit'>Finish</button>
                          </div>
                                  
            
					<?php 
                          
                          }
                            
                          }
                           
                           $i++;
                         } 
                      }
          else
          {
                   $countquery = "select * from user_to_question where userid = $uid and quizid = $qid and completed = 1";
                    $countresult = mysql_query($countquery);
                    $countrows = mysql_num_rows($countresult);
                    $ci = $countrows + 1;
                  while($v_rows = mysql_fetch_object($validresult))
                  {
                  $selectquery = "select * from question where questionid = $v_rows->questionid";
                  $selectresult = mysql_query($selectquery);
                  
                  while($select_rows = mysql_fetch_object($selectresult))
                  {
                          $y=1;
                          $optionstring = $select_rows->optionlist;
                          $optiontoken = strtok($optionstring, "/");
      
                          if($bi<=1 || $bi<$vrows){
                            ?>         
                          <div id='question<?php echo $bi;?>' class='cont'>
                          <p class='questions' id="qname<?php echo $bi;?>"> <?php echo $ci?>.<?php echo $select_rows->content;?></p>
                          <?php

                          while ($optiontoken !== false)
                          {

                              $getvalue = $optiontoken;
                              $getvalue = str_replace(" ","-",$getvalue);
                              if($optiontoken == $v_rows->answer)
                              {
                          ?>

                                <input type="radio" checked='checked' value="<?php echo $optiontoken;?>" id='radio1_<?php echo $select_rows->questionid;?>' name='<?php echo $select_rows->questionid;?>' onclick="update(this);"/><?php echo $optiontoken;?>   
                                <br/>
                             <?php 
                                $optiontoken = strtok("/"); 
                                $y++; 
                            }
                            else
                              {
                          ?>
                                <input type="radio"  value="<?php echo $optiontoken;?>" id='radio1_<?php echo $select_rows->questionid;?>' name='<?php echo $select_rows->questionid;?>' onclick="update(this);"/><?php echo $optiontoken;?>   
                                <br/>
                             <?php 
                                $optiontoken = strtok("/"); 
                                $y++; 
                              }

                           }
                           if($optiontoken == $v_rows->answer)
                           {

                             ?>
                          <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $select_rows->questionid;?>' name='<?php echo $select_rows->questionid;?>' onclick="update(this);" />                                                                      
                          <?php } ?>
                          <br/>
                          <button id='<?php echo $bi;?>' class='next btn btn-success' type='button'  >Next</button>
                          </div>                               
                         <?php
                       }elseif($bi==$vrows){?>

                          <div id='question<?php echo $bi;?>' class='cont'>
                          <p class='questions' id="qname<?php echo $bi;?>"> <?php echo $ci?>.<?php echo $select_rows->content;?></p>
      
                          <?php
                          while ($optiontoken !== false)
                          {
                              $getvalue = $optiontoken;
                              $getvalue = str_replace(" ","-",$getvalue);
                              if($optiontoken == $v_rows->answer)
                              {
                          ?>

                                <input type="radio" checked='checked' value="<?php echo $optiontoken;?>" id='radio1_<?php echo $select_rows->questionid;?>' name='<?php echo $select_rows->questionid;?>' onclick="update(this);"/><?php echo $optiontoken;?>   
                                <br/>
                             <?php 
                                $optiontoken = strtok("/"); 
                                $y++; 
                            }
                            else
                              {
                          ?>
                                <input type="radio"  value="<?php echo $optiontoken;?>" id='radio1_<?php echo $select_rows->questionid;?>' name='<?php echo $select_rows->questionid;?>' onclick="update(this);"/><?php echo $optiontoken;?>   
                                <br/>
                             <?php 
                                $optiontoken = strtok("/"); 
                                $y++; 
                              }

                           }
                           if($optiontoken == $v_rows->answer)
                           {

                             ?>
                          <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $select_rows->questionid;?>' name='<?php echo $select_rows->questionid;?>' onclick="update(this);" />                                                                      
                          <?php } ?>
                          
                          <button id='<?php echo $bi;?>' class='next btn btn-success' type='submit' >Finish</button>
                          </div>
                                  
            
          <?php 
                          }
                          }
                           $bi++;
                           $ci++;
                         } 
                      }
          ?>

				</form>
			</div>
		</div>

		
		<script>
		$('.cont').addClass('hide');
		count=$('.questions').length;
		 $('#question'+1).removeClass('hide');
		 
		 $(document).on('click','.next',function(){
		     last=parseInt($(this).attr('id'));     
		     nex=last+1;
		     $('#question'+last).addClass('hide');
		     
		     $('#question'+nex).removeClass('hide');
		 });

      

     /* function update()
      {
        var option=$('input[type="radio"]:checked').val();
        var uid = <?php echo $uid ?>;
        var qid = <?php echo $qid ?>;
      $.ajax({
       type: "POST",
       url: "update.php",
       data: { uid : uid, qid : qid,option : option},
       cache: false,
       success: function(response)
       {
         alert(option);

       }
     });
    }*/

    function update(myRadio) {
         var option = myRadio.value;
         var quesid = $(myRadio).attr('name');
         var uid = <?php echo $uid ?>;
        var qid = <?php echo $qid ?>;
      $.ajax({
       type: "POST",
       url: "update.php",
       data: { uid : uid, qid : qid,option : option, quesid : quesid},
       cache: false,
       success: function(response)
       {
       }
     });      
    }
	             
         setTimeout(function() {
             $("form").submit();
          }, 60000);
		</script>
	</body>
    
</html>