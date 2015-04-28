<html>
<head>


<link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <!--Script required for Google chart !-->
    <script type="text/javascript" src="../jscss/googleChart.js"></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="../jscss/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="../jscss/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    
    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <link rel="stylesheet" href="../jscss/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    
    <link rel="stylesheet" href="../jscss/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

</head>
<body>

<h3> Fancybox Test</h3>

A fancybox will load in 3 seconds


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