<?php
<<<<<<< HEAD
include '../jscss/calendar/classes/calendar.php';
 
$month = isset($_GET['m']) ? $_GET['m'] : NULL;
$year  = isset($_GET['y']) ? $_GET['y'] : NULL;
 
$calendar = Calendar::factory($month, $year);
 
$calendar->standard('today')
    ->standard('prev-next')
    ->standard('holidays')
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>PHP Calendar</title>
        <link type="text/css" rel="stylesheet" media="all" href="..\jscss\calendar\css\calender.css" />
    </head>
    <body>
            
        <table class="calendar small">
    <thead>
        <tr class="navigation">
            <th class="prev-month"><a href="<?php echo htmlspecialchars($calendar->prev_month_url()) ?>"><?php echo $calendar->prev_month(0, '&laquo;') ?></a></th>
            <th colspan="5" class="current-month"><?php echo $calendar->month() ?> <?php echo $calendar->year ?></th>
            <th class="next-month"><a href="<?php echo htmlspecialchars($calendar->next_month_url()) ?>"><?php echo $calendar->next_month(0, '&raquo;') ?></a></th>
        </tr>
        <tr class="weekdays">
            <?php foreach ($calendar->days(1) as $day): ?>
                <th><?php echo $day ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($calendar->weeks() as $week): ?>
            <tr>
                <?php foreach ($week as $day): ?>
                    <?php
                    list($number, $current, $data) = $day;
                     
                    $classes = array();
                    $output  = '';
                     
                    if (is_array($data))
                    {
                        $classes = $data['classes'];
                        $title   = $data['title'];
                        $output  = empty($data['output']) ? '' : '<ul class="output"><li>'.implode('</li><li>', $data['output']).'</li></ul>';
                    }
                    ?>
                    <td class="day <?php echo implode(' ', $classes) ?>">
                        <span class="date" title="<?php echo implode(' / ', $title) ?>">
                            <?php if ( ! empty($output)): ?>
                                <a href="#" class="view-events"><?php echo $number ?></a>
                            <?php else: ?>
                                <?php echo $number ?>
                            <?php endif ?>
                        </span>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
</html>
=======
date_default_timezone_set('Asia/Kuala_Lumpur');
$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];
 
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $cYear + 1;
}
?>

<table width="200">
<tr align="center">
<td bgcolor="#999999" style="color:#FFFFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="50%" align="left">  <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF">Previous</a></td>
<td width="50%" align="right"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF">Next</a> </td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center">
<table width="100%" border="0" cellpadding="2" cellspacing="2" border="1">
<tr align="center">
<td colspan="7" bgcolor="#999999" style="color:#FFFFFF"><strong><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong></td>
</tr>
<tr>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
</tr>
<?php 
$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
$today = date("d");
for ($i=0; $i<($maxday+$startday); $i++) {
    if(($i % 7) == 0 ) 
        {
            echo "<tr>";
        }
    if($i < $startday) 
    {
        echo "<td style='background-color:silver;'></td>";
    }
 
    else if(($i - $startday +1 ==$today) and ($cMonth == date("n")) and ($cYear == date("Y"))) 
        {echo "<td align='center' valign='middle' height='20px' style='background-color:grey;color:white;'><strong>". ($i - $startday + 1) . "</strong></td>";} // there I have made the changes. It works perfectly but always highlight it on next month.
    else 
        {echo "<td align='center' valign='middle' height='20px' style='background-color:silver;'>". ($i - $startday + 1) . "</td>";}
     
    if(($i % 7) == 6 ) 
        {echo "</tr>";}
}
?>
</table>
>>>>>>> origin/kit
