 <?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
$query_count    = "SELECT count(*) from question";
$result_count   = mysql_query($query_count,$link);
$count          = mysql_result($result_count,0) + 1;
$quizid         = intval($_REQUEST['qid']);

$query_quiz = "SELECT * FROM quiz where quizid=$quizid";
$result = mysql_query($query_quiz, $link);
while($row = mysql_fetch_object($result)){
    $q_courseid = $row->course_id;
    $q_coursename = $row->course_name;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Select Question</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
    <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
    <script src="../jscss/datatable/plugin/fnGetFilteredNodes.js"></script> 
    <script src="../jscss/datatable/plugin/fnGetHiddenNodes.js"></script>    
    <script type="text/javascript">
    $(document).ready(function(){
    var table = $('#question').DataTable(
        {     
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">',
            "columns":[
                {"name":"&nbsp;Select All", "orderable":false},
                {"name":"Course", "orderable":true},
                {"name":"Difficulty", "orderable":true},
                {"name":"Question", "orderable":true},
                ],
            "order": [],
            "columnDefs":[
                {
                "targets": "no-sort", 
                "orderable":false
                }],
            initComplete: function () {
                this.api().columns([1,2]).every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
     
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
     
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });
        var quizid = <?php echo $quizid ?>;
        var list = [];
        $('form[name=select_question]').submit(function(){ //replace 'yourformsnameattribute' with the name of your form
        //$(table.fnGetHiddenNodes()).find('input:checked').appendTo(this); //this is what passes any hidden nodes to your form when a user clicks SUBMIT on your FORM
        //var nodes = table.fnGetHiddenNodes();
        //alert (nodes);
        var rowcollection = table.$(".ques_check:checked",{page:"all"});
        rowcollection.each(function(index,elem){
            var quesid = $(elem).val();
            list.push(quesid);
            //var quesid = JSON.stringify(checkedvalues);
           
                //alert(checkvalues);
            });
             $.ajax({
                type: "POST",
                url: "select.php",
                //data: { quesid : quesid, quizid : quizid},
                data: { quizid : quizid,list : list},
                cache: false,
                success: function(data)
                {
                    //alert(response);
                   
                   window.location.href ="view_question.php?qid=" + quizid;
                   alert("Select Question Successful!");
                }
            });   
        });
 
        //$('.checkall').click( function() { //this is the function that will mark all your checkboxes when the input with the .checkall class is clicked
        //$('input',table.fnGetFilteredNodes()).attr('checked',this.checked); //note it's calling fnGetFilteredNodes() - this is so it will mark all nodes whether they are filtered or not
        //} );

        $('#select_all_ques').click(function () {
            $(':checkbox', table.rows().nodes()).prop('checked', this.checked);
        });
    });

    

    function select_all(p_param){
        
        checkboxes = document.getElementsByName("chk_ques[]");
        for(var i=0; i<(checkboxes.length); i++){
            // alert(checkboxes[i]);
            checkboxes[i].checked = p_param.checked;
        }

    
    }
    </script>
    <style type="text/css">
    /*.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{
        padding: 4px;
        vertical-align: middle;
    }
    .table>tfoot>tr>th{
        
        border: none;
    }
    .table>tfoot>tr>th>select{
        width: 100px;
    }*/
    </style>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="viewquiz.php">Quiz</a></li>
    <li><a href="view_question.php?qid=<?php echo $quizid?>">Questions</a></li>
    <li class="active">Select Question</li>
    </ol>
<center>Select Question</center>
<?php
//if(isset($_GET['action'])=='selectquestion') {
  //  selectquestion();
//}
//else
//show form
?>
<form action="?action=selectquestion&qid=<?php echo $quizid?>" method="post" name = "select_question">
<!-- Course: <select name="sel_course">
    <option value="" selected disabled>--- Select a Course ---</option>
    <option value="0">All</option>
    <?php
    $sel_course = "SELECT * FROM course";
    $result = mysql_query($sel_course, $link);
    while($row = mysql_fetch_object($result)){
        ?>
        <option value="<?php echo $row->courseid ?>"><?php echo $row->coursename ?>
        <?php
    }
    ?>
</select>
Lesson: <select name="sel_lesson">
    
</select> -->
<table id = "question" class="table table-striped table-bordered" cellspacing="0">

    <thead>
        <tr>
        <th class="no-sort" align="center" width="10%">
            <!-- <input type="checkbox" onclick="select_all(this)">&nbsp;Select All -->
            <input type="checkbox" id="select_all_ques" name="select_all_ques">&nbsp;Select All
        </th>
        <th>Course</th>
        <th width="10%">Difficulty</th>
        <th align="center">Question</th>
    </tr>
    </thead>

    <tfoot>
        <tr>
        <th class="no-sort" align="center" width="10%">
            <!-- <input type="checkbox" onclick="select_all(this)">&nbsp;Select All -->
            Select All
        </th>
        <th>Course</th>
        <th width="10%">Difficulty</th>
        <th align="center">Question</th>
    </tr>
    </tfoot>


    <?php
        $query2="SELECT * from question";
        $result2=mysql_query($query2,$link);

        $arr_quesid = array();
        $query_qtq = "SELECT * FROM quiz_to_question where quizid=$quizid";
        $result3 = mysql_query($query_qtq, $link);
        while($row = mysql_fetch_object($result3)){
            array_push($arr_quesid, $row->questionid);
        }
        // print_r($arr_quesid);

        while($b_rows=mysql_fetch_object($result2))
        {
            $check_flag = false;
            // Checks questions already in quiz
            if(in_array($b_rows->questionid, $arr_quesid)){
                $check_flag = true;
            }
    ?>
            <tr>
                <td>
                    <div align = "center">
                    <input type="checkbox" class="ques_check" id="chk_ques" 
                        name="chk_ques[]" value="<?php echo $b_rows->questionid ?>"
                        <?php echo ($check_flag==true ? 'checked' : '') ?>>
                    </td>
                <td><?php echo $b_rows->course_name ?></td>
                <td><?php echo $b_rows->difficulty ?></td>
                <td><?php echo $b_rows->content ?></td>
            </tr>
    <?php
        }
    ?>

</table>

<div align = "center">

    <input class="btn btn-default" type="submit" value="Add">
    &nbsp&nbsp
    <input class="btn btn-default" type="reset">
    <!-- <button class="btn btn-default" type="button">Select All</button> -->
</td>
</tr>
</form>
</body>
</html>


 <?php
 function selectquestion() 
 {
    include '../inc/db_config.php';
    $add_quizid     = intval($_REQUEST['qid']);
    
    // $add_questionid = intval($_POST['questionselect']);



    $flag  = false;
    $check = "SELECT * from quiz_to_question where quizid=$add_quizid";
    $check_result  = mysql_query($check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(isset($add_questionid)){
                if(strcmp($add_questionid,$result_rows->questionid)!=0)
                $flag=false;
                else
                $flag=true;
            }
        }
    
    if($flag==false)
    {
        $delete = "DELETE from quiz_to_question WHERE quizid=$add_quizid";
        mysql_query($delete);
        $insert_query = "";
        
        if(isset($_POST['chk_ques'])){

            $insert_query = "INSERT into quiz_to_question(quizid, questionid) VALUES";
            foreach($_POST['chk_ques'] as $selected){
                // echo $selected."<br>";

                $insert_query .= "('$add_quizid', '$selected'),";
                                    // echo $insert_query."<br>";
            }
            
            $insert_query = chop($insert_query, ",");

            if(!mysql_query($insert_query,$link)){
             die("Could not select the question.".mysql_error());
            }else
            {
                $test = print_r($_POST['checkedvalues'],true);
                //echo '<script> alert("Select Question Successful!") </script>';
                echo '<script> alert('. $test.') </script>';
                echo '<script language="JavaScript"> window.location.href ="view_question.php?qid='.$add_quizid.'"</script>';
            }
            
        }else{
            echo '<script language="JavaScript"> window.location.href ="view_question.php?qid='.$add_quizid.'"</script>';
        }
            // $sql="INSERT into quiz_to_question(quizid,questionid) 
            //         values('$add_quizid','$add_questionid')";
            
            
        
       
    }
    else{
        echo "Question exsited in this quiz";
    }

 }

?>

<?php

mysql_close($link);
?>


