<?php
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    $m_id=intval($_GET['cid']);
    $query="select coursename,description from course where courseid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_coursename=$m_rows->coursename;
        $m_coursedesc=$m_rows->description;
      
?>
<center>
Course Detail
<hr>
<table>
<tr>
    <td>Course Name:</td><td><?php echo $m_coursename ?></td>
  </tr>
  <tr>
    <td>Course Description:</td><td><?php echo $m_coursedesc ?></td>
  </tr>
<?php
}
mysql_close($link);
?>
</table>
<br>
<a href="courses.php">Return</a>
</center> 
