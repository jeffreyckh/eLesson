<?php
    session_start();
    $urank = $_SESSION['rank'];
    if ($urank == 3)
    {
      echo '<script language="javascript">';
      echo 'alert("You have no permission to access here")';
      echo '</script>';
      
      header("Location: ../user/userHome.php");
      die();
    }
    include'../inc/db_config.php';
    include '../inc/header.php';
    if($urank == 2)
        {
            include '../inc/normalAdminNav.php';
        }
        else
        {
           include 'adminNav.php'; 
        }
    
    //$quizid=intval($_REQUEST['qid']);
    $quesid=intval($_REQUEST['quid']);
    $query="select * from question where questionid=$quesid";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_content=$m_rows->content;
        $m_answer=$m_rows->answer;
        $m_optionlist=$m_rows->optionlist;
        $m_difficulty=$m_rows->difficulty;
    }

    
      //echo $m_directionid;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Modify Question</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
    $(function() {
        var addDiv = $('#addinput');
        var i = $('#addinput #extra').size() + 1;
        $('#addNew').on('click', function() {
          $('<div id="extra"><input type="text" id="p_new" size="20" name="p_new[]' + 
          '" value="" placeholder="Add answer option here" /><a href="#" id="remNew"><button type="button" class="btn btn-default" title="Remove an option">' + 
          '<img src="../img/minusicon_white.png"></button></a></div>').appendTo(addDiv);
        i++;
          return false;
        });

        $(document).on('click', "#remNew", function() {
          if( i > 1 ) {
            $(this).parents('#extra').remove();
            // i--;
          }
          return false;
        });
      });
    </script>
</head>
<body>
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="view_questionlist.php">Questions</a></li>
    <li class="active">Edit Question</li>
    </ol>

Modify Question
<hr>

<?php
if(isset($_GET['action'])=='editquestion') {
    editquestion();
}else
//show form
?>
<form action="?action=editquestion" method="post">
<input type="hidden" name="quid" value="<?php echo $quesid?>">

<table class="table table-bordered">
<tr>
    <td>Question Content:</td><td><textarea name="qcont" id="qcont" rows="10" cols="80"><?php echo $m_content ?></textarea></tr>
    <tr> <td>Answer:</td><td><input type="text" name="qanswer" value="<?php echo $m_answer ?>"></td></tr>
    <tr>
      <td>Option List(use '/' to separate):</td>
      <td>
        <?php

        $option_arr = array();
        $option_token = strtok($m_optionlist, "/");

        while($option_token !== false){
          array_push($option_arr, $option_token);
          $option_token = strtok("/");
        }
        // echo "<br>";
        // print_r($option_arr);
        // echo "<br>";

        ?>
        <div id="addinput">
          <a href="#" id="addNew">
            <button type="button" class="btn btn-default" title="Add Option">
              <img src="../img/addicon_white.png">
              <!-- Add -->
          </button>
          </a>
          <?php

          if($option_arr != null){
            for($i=0; $i<sizeof($option_arr); $i++){
              if($i > 0){
                echo "<div id='extra'>".
                    "<input type='text' id='p_new' size='20' name='p_new[]' value='$option_arr[$i]' />".
                    "<a href='#' id='remNew'><button type='button' class='btn btn-default' title='Remove an option'><img src='../img/minusicon_white.png'></button></a>".
                    "</div>";  
              }
              
            }
          }
          ?>
        </div>
        <!-- <input type="text" name="qopt" value="<?php echo $m_optionlist ?>"> -->
      </td>
    </tr>
    <tr><td>Difficulty:</td><td>
      <select name="ddlDifficulty">
        <?php
        if($m_difficulty == "Easy")
          echo '<option value="Easy" selected>Easy</option>';
        else
          echo '<option value="Easy" >Easy</option>';

        if($m_difficulty == "Normal")
          echo '<option value="Normal" selected>Normal</option>';
        else
          echo '<option value="Normal">Normal</option>';

        if($m_difficulty == "Hard")
          echo '<option value="Hard" selected>Hard</option>';
        else
          echo '<option value="Hard">Hard</option>';
        ?>
      </select></td></tr>
    </table>
    <div align = "center"><input class="btn btn-default" type="submit" value="Submit">&nbsp&nbsp<input class="btn btn-default" type="reset">
</form>
<script>
      tinymce.init({
    selector: "textarea",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager media youtube"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code | youtube",
   image_advtab: true ,
   external_filemanager_path:"/eLesson/jscss/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "/eLesson/jscss/filemanager/plugin.min.js"}
    
    });
  </script>
  <br><br>
  </body>
  </html>
<?php
function editquestion() 
 {
 include("../inc/db_config.php");
    //$quizid=intval($_REQUEST['qid']);

    if(isset($_SESSION['username'])){
      $modify_user = $_SESSION['username'];
    }
    date_default_timezone_set("Asia/Kuching");
    $modify_time  = date("Y-m-d h:i:s");
    
    $quesid=intval($_POST['quid']);
    $edit_content=$_POST['qcont'];
    $edit_answer=$_POST['qanswer'];

    // $edit_optionlist=$_POST['qopt'];

    $edit_option = "";
    $p_new      = $_POST['p_new'];
    array_unshift($p_new, $edit_answer);
    $size_p     = sizeof($p_new) - 1;

    for($i=0; $i<sizeof($p_new); $i++){
      if($i == 0){
        $p_new[$i] = $edit_answer;
      }

      // $p_new[$i] = str_replace("<","&lt",$p_new[$i]);
      // $p_new[$i] = str_replace(">","&gt",$p_new[$i]);
      $p_new[$i] = htmlspecialchars($p_new[$i]);
      
      $edit_option .= $p_new[$i];
      if($i<$size_p){
        $edit_option .= "/";
      }
    }

    $edit_ddlDifficulty=$_POST['ddlDifficulty'];
    $flag=true;
    $check="select * from question";
    $check_result=mysql_query($check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(strcmp($edit_content,$result_rows->content)!=0 ||
                (strcmp($edit_answer,$result_rows->answer)!=0) ||
                (strcmp($edit_option,$result_rows->optionlist)!=0) ||
                (strcmp($edit_ddlDifficulty,$result_rows->difficulty)!=0)
              )
            $flag=false;
            else
            $flag=true;
        }
    
    if($flag==false)
    {

            //   $edit_answer = str_replace("/","/",$edit_answer);
            //  $edit_answer = str_replace("<","&lt",$edit_answer);
            // $edit_optionlist = str_replace(">","&gt",$edit_optionlist);
            //  $edit_optionlist = str_replace("/","/",$edit_optionlist);
            // $edit_content = str_replace("<","&lt",$edit_content);
            // $edit_content = str_replace(">","&gt",$edit_content);
            $edit_answer  = htmlspecialchars($edit_answer);
            $edit_option  = htmlspecialchars($edit_option);
            $edit_content = htmlspecialchars($edit_content);
       
            $sql="UPDATE question set 
                  content='$edit_content',answer='$edit_answer',
                  optionlist = '$edit_option',difficulty = '$edit_ddlDifficulty',
                  modified_on = '$modify_time', modified_by = '$modify_user'
                  where 
                  questionid=$quesid";
            if(!mysql_query($sql,$link)){
              echo $sql;
             die("Could not update the data!".mysql_error());
             }
            else
            {
            
                echo '<script> alert("Modify Question Successful!") </script>';
                
                echo '<script language="JavaScript"> window.location.href ="view_questionlist.php" </script>';
                
                
            }
    }
    else{
        echo "Question Existed";
    }

}


?>

<?php
mysql_close($link);
?>
