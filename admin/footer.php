<br>
<?php
$time_end=getmicrotime();
echo $settings['copyright']."<br>\nProcessed in ".number_format($time_end-$time_start,3,'.','')." ms, ".$db->query_num." queries in ".$db->query_time." ms.";
?>
<br>
</body>
</html>
<?php
//echo '<p align="left">'.$db->query_str.'</p>';
//print_r($GLOBALS);
?>
