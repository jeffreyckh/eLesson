<html>
<head>

<!--- These are the scripts and styles needed for fancybox to work --->
<script type="text/javascript" src="http://qwisk.com/sbmedia/scripts/libraries/jquery-1.3.2-mod.js" charset="utf-8"></script>
<script type="text/javascript" src="http://qwisk.com/sbmedia/scripts/libraries/jquery.fancybox-1.2.6.js" charset="utf-8"></script>
<link href="http://qwisk.com/sbmedia/css/jquery.fancybox-1.2.6.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>

<h3> Fancybox Test</h3>

A fancybox will load in 3 seconds

<!--- Currently fancybox only works on links in your page.  This div hides a link, who's href we change dynamically --->
<div id="hidden_clicker" style="display:none">
<a id="hiddenclicker" href="http://asdf.com" >Hidden Clicker</a>
</div>

<script type="text/javascript" >

// Register all links with-flash as fancybox's
$(document).ready(function() {
 $("a.overlay-flash").fancybox({
 'padding': 0,
 'zoomOpacity': true,
 'zoomSpeedIn': 500,
 'zoomSpeedOut': 500,
 'overlayOpacity': 0.75,
 'frameWidth': 530,
 'frameHeight': 400,
 'hideOnContentClick': false
 });
});

// This function allows you to call the fancy box from javascript
// origional source: http://outburst.jloop.com/2009/08/06/call-fancybox-from-flash/
function callBoxFancy(my_href) {
var j1 = document.getElementById("hiddenclicker");
j1.href = my_href;
$('#hiddenclicker').trigger('click');
}

// Call the Fancy Box 3 seconds after the page loads
$(document).ready(function() {
 window.setTimeout("callFancyBox('http://google.com');", 3000)
});
</script>

</body>
</html>