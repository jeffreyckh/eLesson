<?php
// MYSQL Database
class db_sql {
	var $usepconnect=0;
	var $server='localhost';
	var $port='3306';
	var $user='root';
	var $password='';
	var $database='';
	var $link_id=0;
	var $query_id=0;

	var $query_num=0;
	var $query_time=0;
	var $query_str='';

	// Database server connect
	function connect(){
		if ($this->usepconnect==1){
			$this->link_id=mysql_pconnect($this->server.':'.$this->port,$this->user,$this->password);
		}else{
			$this->link_id=mysql_connect($this->server.':'.$this->port,$this->user,$this->password);
		}
		if (!$this->link_id){
			$this->halt('Database server "'.$this->server.'" could not connect, please contact admin.');
		}
	}
	// Select database
	function select_db(){
		if(!mysql_select_db($this->database,$this->link_id)){
			$this->halt('"'.$this->database.'"Select database fault, please contact admin');
		}
	}
	// SQL search
	function query($query_string){
		$sql_start=getmicrotime();
		$this->query_id=mysql_query($query_string,$this->link_id);
		$sql_end=getmicrotime();
		if (!$this->query_id){
			$this->halt('Invalid SQL: '.$query_string);
		}
		$this->query_num++;
		$this->query_time+=number_format($sql_end-$sql_start,3,'.','');
		$this->query_str.='('.number_format($sql_end-$sql_start,3,'.','').'ms) '.$query_string.'<br>';
		return $this->query_id;
	}
	// Get search result
	function fetch_array($query_id,$type=MYSQL_ASSOC){
		return mysql_fetch_array($query_id,$type);
	}
	// Get number of row
	function num_rows($query_id){
		return mysql_num_rows($query_id);
	}
	// Free memory of search result
	function free_result($query_id){
		return mysql_free_result($query_id);
	}
	// Get first row of search result
	function query_first($query_string){
		$query_id=$this->query($query_string);
		$returnarray=$this->fetch_array($query_id);
		$this->free_result($query_id);
		return $returnarray;
	}
	
/*******************************/	
	// Get first row of search result
	function fetch_one_array($query_string){
		$query_id=$this->query($query_string);
		$returnarray=$this->fetch_array($query_id);
		$this->free_result($query_id);
		return $returnarray;
	}

      function affected_rows() {
               $this->affected_rows = mysql_affected_rows($this->link_id);
               return $this->affected_rows;
      }



/*********************************/
	// Get previos INSERT ID
	function insert_id(){
		return mysql_insert_id($this->link_id);
	}
	// Close database
	function close(){
		return mysql_close();
	}
	// Error Interrupt
	function halt($msg){
		echo htmlspecialchars($msg);
		exit;
	}
}
?>
