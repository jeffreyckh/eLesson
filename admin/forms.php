<?php
error_reporting(7);

class FORMS {

      function formheader($arguments=array()) {

               if ($arguments[enctype]){
                   $enctype="enctype=\"$arguments[enctype]\"";
               } else {
                   $enctype="";
               }
               if (!isset($arguments[method])) {
                   $arguments[method] = "post";
               }
               if (!isset($arguments[action])) {
                   $arguments[action] = $_SERVER[PHP_SELF];
               }

               if (!$arguments[colspan]) {
                   $arguments[colspan] = 2;
               }


               echo "<table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\" class=\"tableoutline\">\n";
               echo "<form action=\"$arguments[action]\" $enctype method=\"$arguments[method]\" name=\"$arguments[name]\" $arguments[extra]>\n";
               if ($arguments[title]!="") {
                   echo "<tr id=\"cat\">
                          <td class=\"tbhead\" colspan=\"$arguments[colspan]\">
                          <b> $arguments[title] </b>
                          </td>
                         </tr>\n";
               }

      }

      function formfooter($arguments=array()){

               echo "<tr class=\"tbhead\">\n";

               if ($arguments[confirm]==1) {

                   //$arguments[colspan] = 1;

                   $arguments[button][submit][type] = "submit";
                   $arguments[button][submit][name] = "submit";
                   $arguments[button][submit][value] = "confirm";
                   $arguments[button][submit][accesskey] = "y";

                   $arguments[button][back][type] = "button";
                   $arguments[button][back][value] = "cancel";
                   $arguments[button][back][accesskey] = "r";
                   $arguments[button][back][extra] = " onclick=\"history.back(1)\" ";

               } elseif (empty($arguments[button])) {

                   $arguments[button][submit][type] = "submit";
                   $arguments[button][submit][name] = "submit";
                   $arguments[button][submit][value] = "submit";
                   $arguments[button][submit][accesskey] = "y";

                   $arguments[button][reset][type] = "reset";
                   $arguments[button][reset][value] = "reset";
                   $arguments[button][reset][accesskey] = "r";

               }

               if ($arguments[nextpage]==1) {

                   $arguments[button][nextpage][type] = "submit";
                   $arguments[button][nextpage][name] = "nextpage";
                   $arguments[button][nextpage][value] = "Continued to add next page";
                   $arguments[button][nextpage][accesskey] = "n";

               }


               if (empty($arguments[colspan])) {
                   $arguments[colspan] = 2;
               }

               echo "<td colspan=\"$arguments[colspan]\" align=\"center\">\n";
               if (isset($arguments) AND is_array($arguments)) {
                   foreach ($arguments[button] AS $k=>$button) {
                            if (empty($button[type])) {
                                $button[type] = "submit";
                            }
                            echo " <input class=\"bginput\" accesskey=\"$button[accesskey]\" type=\"$button[type]\" name=\"$button[name]\" value=\" $button[value] \" $button[extra]> \n";
                   }
               }
               echo "</td>
                     </tr>\n";
               echo "</form>\n";
               echo "</table>\n";

      }

      function tableheader() {
               echo "<table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\" class=\"tableoutline\">\n";
      }

      function tablefooter() {
               echo "</table>\n";
      }

      function tableseparate() {

               $this->tablefooter();
               echo "<br>\n";
               $this->tableheader();

      }

      function makecategory($arguments = array()) {

               if (!is_array($arguments)) {
                   $title = $arguments;
               } else {
                   $title = $arguments[title];
               }
               if ($arguments[separate]==1) {
                   $this->tableseparate();
               }

               echo "<tr class=\"tbcat\" id=\"cat\">
                       <td colspan=\"2\">".htmlspecialchars($title)."</td>
                     </tr>\n";

      }

      function maketd($arguments = array()) {

               echo "<tr ".$this->getrowbg()." nowrap>";
               foreach ($arguments AS $k=>$v) {
                        echo "<td>$v</td>";
               }
               echo "</tr>\n";

      }

      function makeinput($arguments = array()) {

               if (empty($arguments[size])) {
                   $arguments[size] = 35;
               }
               if (empty($arguments[maxlength])) {
                   $arguments[maxlength] = 200;
               }
               if ($arguments[html]) {
                   $arguments[value] = htmlspecialchars($arguments[value]);
               }
               if (!empty($arguments[css])) {
                   $class = "class=\"$arguments[css]\"";
               }

               if (empty($arguments[type])) {
                   $arguments[type] = "text";
               }
               echo "<tr ".$this->getrowbg()." nowrap>
                      <td width=\"50%\">$arguments[text]</td>
                       <td>
                         <input $class type=\"$arguments[type]\" name=\"$arguments[name]\" size=\"$arguments[size]\" maxlength=\"$arguments[maxlength]\" value=\"$arguments[value]\" $arguments[extra]>\n
                       </td>
                     </tr>\n";

      }

      function makefile($arguments = array()) {

               echo "<tr ".$this->getrowbg()." nowrap>
                      <td width=\"50%\">$arguments[text]</td>
                       <td>
                         <input type=\"file\" name=\"$arguments[name]\" $arguments[extra]>\n
                       </td>
                     </tr>\n";

      }

      function maketextarea($arguments = array()){

               // $text,$name,$value="",$cols=40,$rows=7,$extra=""
               if (empty($arguments[cols])) {
                   $arguments[cols] = 40;
               }
               if (empty($arguments[rows])) {
                   $arguments[rows] = 7;
               }
              if (!empty($arguments[html])) {
                   $arguments[value] = htmlspecialchars($arguments[value]);
               }

               echo "<tr ".$this->getrowbg()." nowrap>
                     <td width=\"50%\" valign=\"top\">$arguments[text]</td>
                     <td>
                       <textarea type=\"text\" name=\"$arguments[name]\" cols=\"$arguments[cols]\" rows=\"$arguments[rows]\" $arguments[extra]>$arguments[value]</textarea>
                     </td>
                   </tr>\n";

      }

      function inithtmlarea() {
?>
<script language="Javascript1.2">
<!-- // load htmlarea
_editor_url = "../htmlarea/";                     // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
 document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
 document.write(' language="Javascript1.2"></scr' + 'ipt>');
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }
// -->
</script>
<?php
      }
      function makehtmlarea($arguments = array()) {

               $this->maketextarea(array('text'=>$arguments[text],
                                         'name'=>$arguments[name],
                                         'value'=>$arguments[value],
                                         'html'=>1,
                                         'cols'=>$arguments[cols],
                                         'rows'=>$arguments[rows]
                                         ));
               if (empty($arguments[width])) {
                   $arguments[width] = 700;
               }
               if (empty($arguments[height])) {
                   $arguments[height] = 500;
               }

?>
<script language="JavaScript1.2" defer>
var config = new Object(); // create new config object

config.width = "<?php echo $arguments[width];?>";
config.height = "<?php echo $arguments[height];?>";

config.debug = 0;

editor_generate('<?php echo $arguments[name];?>',config);

</script>
<?php

      }

      function makeorderinput($arguments = array()) {

               if (empty($arguments[text])) {
                   $arguments[text] = "Order:";
               }
               if (empty($arguments[name])) {
                   $arguments[name] = "displayorder";
               }

               $this->makeinput(array('text'=>$arguments[text],
                                      'name'=>$arguments[name],
                                      'value'=>$arguments[value],
                                      'size'=>3,
                                      'maxlength'=>3
                                      ));

      }

      function makeselect($arguments = array()){

               if ($arguments[html]==1) {
                   $value = htmlspecialchars($value);
               }
               if ($arguments[multiple]==1) {
                   $multiple = " multiple";
                   if ($arguments[size]>0) {
                       $size = "size=$arguments[size]";
                   }
               }

               echo "<tr ".$this->getrowbg().">
                      <td width=\"50%\" valign=\"top\">$arguments[text]</td>
                      <td>
                      <select name=\"$arguments[name]\"$multiple $size $arguments[extra]>\n";
               if (is_array($arguments[option])) {

                   foreach ($arguments[option] AS $key=>$value) {
                            if (!is_array($arguments[selected])) {
                                if ($arguments[selected]==$key) {
                                    echo "<option value=\"$key\" selected class=\"{$arguments[css][$key]}\">$value</option>\n";
                                } else {
                                    echo "<option value=\"$key\" class=\"{$arguments[css][$key]}\">$value</option>\n";
                                }

                            } elseif (is_array($arguments[selected])) {

                                if ($arguments[selected]["$key"]==1) {
                                    echo "<option value=\"$key\" selected class=\"{$arguments[css][$key]}\">$value</option>\n";
                                } else {
                                    echo "<option value=\"$key\" class=\"{$arguments[css][$key]}\">$value</option>\n";
                                }
                            }
                   }
               }

               echo "</select>\n";
               echo "</td>
                     </tr>\n";

      }

      function makeyesno($arguments = array()) {

               $arguments[option] = array('1'=>'Yes','0'=>'No');
               $this->makeselect($arguments);

      }
      function makesex($arguments = array()) {

               $arguments[option] = array('unknow'=>'Unknown','male'=>'Male','female'=>'Female');
               $this->makeselect($arguments);

      }


      function makehidden($arguments = array()){

               echo "<input type=\"hidden\" name=\"$arguments[name]\" value=\"$arguments[value]\">\n";

      }


      function getrowbg() {

               global $bgcounter;
               if ($bgcounter++%2==0) {
                   return "class=\"firstalt\"";
               } else {
                   return "class=\"secondalt\"";
               }

      }

    
      var $cachesorts = array();

      function cachesorts() {

               global $db,$art_prefix;
               $sorts = $db->query("SELECT * FROM ".$art_prefix."sort ORDER BY displayorder,binary title,sortid ASC");
               while ($sort = $db->fetch_array($sorts)) {
					  $this->cachesorts[$sort[parentid]][$sort[sortid]] = $sort;
					  
               }
               $db->free_result($sorts);
               return true;

      }


      var $option = array();
      var $css = array();

      function getsortlistbit($sortid="-1",$level=1) {

               if (isset($this->cachesorts[$sortid])) {
                   foreach($this->cachesorts[$sortid] AS $key => $sort){
                           if ($level==1) {
                               $this->css[$sort[sortid]] = "option_sort";
                           }
                           if (!isset($this->filter[$key])) {
                               $this->option[$sort[sortid]] = str_repeat("--",$level-1)." $sort[title]";
                           }
                           $this->getsortlistbit($sort[sortid],$level+1);
                   }
               }

      }


      var $filter = array();
      function getsortlist($arguments = array()) {

               if (empty($this->cachesorts)) {
                   $this->cachesorts();
               }

               if (!empty($arguments[extra])) {
                   foreach ($arguments[extra] AS $key=>$value) {
                            $this->option[$key] = $value;
                   }
               }
               if (!empty($arguments[filter])) {
                   $this->filter = $arguments[filter];
               }


               $this->getsortlistbit();

               $this->makeselect(array('text'=>$arguments[text],
                                       'name'=>$arguments[name],
                                       'selected'=>$arguments[selected],
                                       'option'=>$this->option,
                                       'css'=>$this->css));


      }
      function getmanufactures($arguments = array()){
	           
			   global $db,$prod_prefix;
		   	   $result=$db->query("SELECT id,scname,sename,displayorder FROM ".$prod_prefix."mfr ORDER BY sename");
		   	   $option[] = "-----Select-----";
			   while($row=$db->fetch_array($result)){
		       		$option[$row['id']] =  stripcslashes($row[sename])."-". stripcslashes($row[scname]);
			   }
			   $option['other'] = "Other";
			   $arguments[option]=$option;

			   $this->makeselect($arguments);
	  
	  }
      function getmanufactures2($arguments=array()){
	           
			   global $db,$prod_prefix;

					echo " <script>
					   
					   function showbrowse(arg){
					             var val='';
								 for(var j=1;j<=arg;j++){
									val += \"<select name='mfrids[]' id='mfrids'></select><select name='series[]' id='series'></select><br>\";
          			                
								 }
								 input.innerHTML=val;
					   }
					   function showblock(arg){
					            for(var i=1;i<=arg;i++){
								   
								}
					   }
					   function s_h(obj){ 

	     					   for(var i=1;i<=obj.options.selectedIndex;i++){
		  					      document.all[\"ss\" + i].style.display='block';
	    					    }
	    					    for(var i=obj.options.selectedIndex+1;i<obj.options.length;i++){
		 					      document.all[\"ss\" + i].style.display='none';
	    					    }

					   }
					   function s_h_a(obj){


   					          for(var i=1;i<obj.options.length;i++){
						            document.all[\"ss\" + i].style.display='none';
   					          }

					   }

					   </script> ";
 				    echo "<tr ".$this->getrowbg()." nowrap id=\"ss{$jj}\" style=\"display:block\">
					         <td>$arguments[text]</td>
							 <td><select name=select onChange=\"if(this.options[selectedIndex].value){s_h(this);} else s_h_a(this)\">";
						
						echo "<option value=''>Select number</option>";
						if($arguments[mfrids]){
						  $mfrids = @explode(",",$arguments[mfrids]);
						  $num = count($mfrids) ;
						  for($k=1;$k<=5;$k++){
						      $selected = $k == $num ?  "selected" : false;
						      echo "<option value='$k' $selected>$k</option>";
						  }	 
						}else{
						  for($k=1;$k<=5;$k++){
						      echo "<option value='$k' $selected>$k</option>";
						  }
						}	 
						echo "</select></td>
					   </tr>";
                   if($num){
				     
				       for($jj=1;$jj<=$num;$jj++){
				           echo "<tr ".$this->getrowbg()." nowrap id=\"ss{$jj}\" style=\"display:block\">
					         <td>$arguments[text]</td>
							 <td>
							  <select name='mfrids[]' id='mfrids'><option>-=Select Manufacturer=-</option></select>
							  <select name='series[]' id='series'><option>-=Select Series=-</option></select>
							  </td>
						    </tr>";
				       }
				     if(5-$num>0){  
					   for($jj=$num+1;$jj<=5;$jj++){
				           echo "<tr ".$this->getrowbg()." nowrap id=\"ss{$jj}\" style=\"display:none\">
					         <td>$arguments[text]</td>
							 <td>
							  <select name='mfrids[]' id='mfrids'><option>-=Select Manufacturer=-</option></select>
							  <select name='series[]' id='series'><option>-=Select Series=-</option></select>
							  </td>
						    </tr>";
				       }
					 }
					 
					 
				   }else{
				     for($jj=1;$jj<=5;$jj++){
				         echo "<tr ".$this->getrowbg()." nowrap id=\"ss{$jj}\" style=\"display:none\">
					         <td>$arguments[text]</td>
							 <td>
							  <select name='mfrids[]' id='mfrids'><option>-=Select Manufacturer=-</option></select>
							  <select name='series[]' id='series'><option>-=Select Series=-</option></select>
							  </td>
						    </tr>";
				     }
				   
				 }
					
	  }

	  function makecheckbox($arguments=array()){
	           
               echo "<tr ".$this->getrowbg().">
                      <td width=\"50%\" valign=\"top\">$arguments[text]</td>
                      <td>\n";
               if (is_array($arguments[option])) {

                   foreach ($arguments[option] AS $key=>$value) {
                            if (!is_array($arguments[checked])) {
                                if ($arguments[checked]==$key) {
                                    echo "<input name=\"$arguments[name]\" $arguments[extra] type=checkbox value=\"$key\" checked class=\"{$arguments[css][$key]}\">$value\n";
                                } else {
                                    echo "<input name=\"$arguments[name]\" $arguments[extra] type=checkbox value=\"$key\" class=\"{$arguments[css][$key]}\" >$value\n";
                                }
                            } elseif (is_array($arguments[checked])) { 
                                if (in_array($key,$arguments[checked])) {
                                    echo "<input name=\"$arguments[name]\" $arguments[extra] type=checkbox value=\"$key\" checked class=\"{$arguments[css][$key]}\">$value\n";
                                } else {
                                    echo "<input name=\"$arguments[name]\" $arguments[extra] type=checkbox value=\"$key\" class=\"{$arguments[css][$key]}\">$value\n";
                                }
                            }
                   }
               }

               echo "</td>
                     </tr>\n";
			   
	  }
	  function makeradios($arguments=array()){
	           
               echo "<tr ".$this->getrowbg().">
                      <td width=\"50%\" valign=\"top\">$arguments[text]</td>
                      <td>\n";
               if (is_array($arguments[option])) {

                   foreach ($arguments[option] AS $key=>$value) {
                            if (!is_array($arguments[checked])) {
                                if ($arguments[checked]==$key) {
                                    echo "<input name=\"$arguments[name]\" $arguments[extra] type=radio value=\"$key\" checked class=\"{$arguments[css][$key]}\">$value\n";
                                } else {
                                    echo "<input name=\"$arguments[name]\" $arguments[extra] type=radio value=\"$key\" class=\"{$arguments[css][$key]}\" >$value\n";
                                }
                            } elseif (is_array($arguments[checked])) { 
                                if (in_array($key,$arguments[checked])) {
                                    echo "<input name=\"$arguments[name]\" $arguments[extra] type=radio value=\"$key\" checked class=\"{$arguments[css][$key]}\">$value\n";
                                } else {
                                    echo "<input name=\"$arguments[name]\" $arguments[extra] type=radio value=\"$key\" class=\"{$arguments[css][$key]}\">$value\n";
                                }
                            }
                   }
               }

               echo "</td>
                     </tr>\n";
			   
	  }

      function getmanagers($arguments = array()) {

               global $db,$art_prefix,$site_prefix;
               $managers = $db->query("SELECT manager.managerid,admin.adminname,admin.adminid,admin.admingroup FROM ".$art_prefix."manager as manager
                                          LEFT JOIN ".$site_prefix."admin as admin
                                          ON(manager.userid=admin.adminid)
                                          WHERE manager.sortid='$arguments[sortid]' ORDER BY admin.admingroup DESC,admin.adminname");
               if ($db->num_rows($managers)==0) {
                   $option[0] = "No manager for the section";
               } else {
                   while ($manager = $db->fetch_array($managers)) {
                          $option[$manager[managerid]] = $manager[admingroup]==0 ? "*".$manager[adminname]:$manager[adminname];
                   }
               }

               $this->makeselect(array('text'=>$arguments[text],
                                       'name'=>$arguments[name],
                                       'selected'=>$arguments[selected],
                                       'option'=>$option));
      }
}

?>