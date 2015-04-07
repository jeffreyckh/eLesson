<?php
/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
  +------------------------------------------------------------+
  | Filename.......: admin/class.php                           |
  | Project........: PHP Novel                                 |
  | Version........: 1.1.0                                     |
  | Last Modified..: 2003-01-16                                |
  +------------------------------------------------------------+
  | Author.........: Hyeo <heizes@21cn.com>                    |
  | Homepage.......: http://www.21ds.net                       |
  | Support........: http://www.21ds.net/forum                 |
  +------------------------------------------------------------+
  | Copyright (C) 2002 phpArticle Team. All rights reserved.   |
  +------------------------------------------------------------+
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- */
error_reporting(7);

class buildNav {

      var $limit;
      var $execute,$query;
      var $total_result = 0;
      var $offset = "offset";


      function execute($query){

               global $db,$db_prefix;
			   
               $_GET[$this->offset] = (!isset($_GET[$this->offset]) OR $_GET[$this->offset]<0) ? 0 : $_GET[$this->offset];
               //$this->sql_result = $DB->query($query);

               $_GET[$this->offset] = ($_GET[$this->offset]>$this->total_result) ? $this->total_result-10 : $_GET[$this->offset];

               if (empty($this->limit)) {
                   $this->limit = 40;
               }

               if (isset($this->limit)) {
                   $query .= " LIMIT " . $_GET[$this->offset] . ", $this->limit";
                   
				   $this->sql_result = $db->query($query);
                  
                   $this->num_pages = ceil($this->total_result/$this->limit);
               }
               if ($_GET[$this->offset]+1 > $this->total_result) {
                   $_GET[$this->offset] = $this->total_result-1;
               }

      }


      function show_num_pages($frew = "&laquo;", $rew = 'Previous', $ffwd = '&raquo;', $fwd = 'Next', $separator = '') {
               $current_pg = $_GET[$this->offset]/$this->limit+1;
               if ($current_pg > '5') {
                   $fgp = ($current_pg-5 > 0) ? $current_pg-5 : 1;
                   $egp = $current_pg+4;
                   if ($egp > $this->num_pages) {
                       $egp = $this->num_pages;
                       $fgp = ($this->num_pages-9 > 0) ? $this->num_pages-9 : 1;
                   }
               } else {
                   $fgp = 1;
                   $egp = ($this->num_pages >= 10) ? 10 : $this->num_pages;
               }
               if($this->num_pages > 1) {
                  // searching for http_get_vars
                  foreach ($_GET as $_get_name => $_get_value) {
                           if ($_get_name != $this->offset) {
                               $this->_get_vars .= "&$_get_name=$_get_value";
                           }
                  }
                  $this->listNext = $_GET[$this->offset] + $this->limit;
                  $this->listPrev = $_GET[$this->offset] - $this->limit;
                  $this->theClass = $objClass;
                  if (!empty($rew)) {                                                                                                                                                                                                                                              //$separator [$frew] $rew
                      $return .= ($_GET[$this->offset] > 0) ? "<a href=\"$_GET[PHP_SELF]?$this->offset=0$this->_get_vars\" $this->theClass title=\"First page\">$frew</a> <a href=\"$_GET[PHP_SELF]?$this->offset=$this->listPrev$this->_get_vars\" $this->theClass title=\"Previous\">$rew</a> $separator " : "";
                  }

                  // showing pages
                  if ($this->show_pages_number || !isset($this->show_pages_number)) {
                      for($this->a = $fgp; $this->a <= $egp; $this->a++) {
                          $this->theNext = ($this->a-1)*$this->limit;
                          if ($this->theNext != $_GET[$this->offset]) {
                              $return .= " <a href=\"$_GET[PHP_SELF]?$this->offset=$this->theNext$this->_get_vars\" $this->theClass> ";
                              if ($this->number_type == 'alpha') {
                                  $return .= chr(64 + ($this->a));
                              } else {
                                  $return .= $this->a;
                              }
                              $return .= "</a> ";
                          } else {
                              if ($this->number_type == 'alpha') {
                                  $return .= chr(64 + ($this->a));
                              } else {
                                  $return .= "<b>$this->a</b>";
                              }
                              $return .= ($this->a < $this->num_pages) ? " $separator " : "";
                          }
                      }
                      $this->theNext = $_GET[$this->offset] + $this->limit;
                      if (!empty($fwd)) {
                          $offset_end = ($this->num_pages-1)*$this->limit;                                                                                                                                                                                                                                                       //$separator $fwd [$ffwd]
                          $return .= ($_GET[$this->offset] + $this->limit < $this->total_result) ? "$separator <a href=\"$_GET[PHP_SELF]?$this->offset=$this->listNext$this->_get_vars\" $this->theClass title=\"Next\">$fwd</a> <a href=\"$_GET[PHP_SELF]?$this->offset=$offset_end$this->_get_vars\" $this->theClass title=\"Last Page\">$ffwd</a>" : "";
                      }
                  }
               }
               return $return;
      }

      // [Function : Showing the Information for the Offset]
      function show_info() {
               $return .= "Total: ".$this->total_result." Record, ".$this->num_pages."Page ";
               $list_from = ($_GET[$this->offset]+1 > $this->total_result) ? $this->total_result : $_GET[$this->offset]+1;
               $list_to = ($_GET[$this->offset]+$this->limit >= $this->total_result) ? $this->total_result : $_GET[$this->offset]+$this->limit;
               //$return .= 'Showing Results from ' . $list_from . ' - ' . $list_to . '<br>';
               $return .= "Show: ".$list_from ." - ".$list_to;
               return $return;
      }

      function pagenav() {
               $return = "
                           <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                             <tr>
                               <td>".$this->show_info()."</td>
                               <td align=\"right\">".$this->show_num_pages()."</td>
                             </tr>
                           </table>";

               return $return;
      }
}
?>