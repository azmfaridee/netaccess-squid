<?php

    require_once('../../utils/class.Utility.php');
    
    class UserLogGenerator
    {
        private $conn;
        private $userid;
        private $userip;

        private $timeZoneCorrection;
        private $userLogHTML;
        
        //private $startPage;
		
	private $logintime;
	private $logouttime;
        
        //private $totalNumPages;
        
    
        public function __construct($conn, $userid, $timeZoneCorrection, $logintime , $logouttime, $userip)
	{
            $this->conn = $conn;
            $this->userid = $userid;
            $this->timeZoneCorrection = $timeZoneCorrection;
            $this->timeZoneCorrection *= 3600;
		
	    $this->logintime = $logintime;
	    $this->logouttime = $logouttime;

	    $this->userip = $userip;
			
           //$this->startPage = $page_no -1;
            
        }
        

        public function getUserLogHTML()
	{
            // clear the current log
            $this->userLogHTML = "";
			
	    //$this->totalNumPages = 0;			
            // $query = "select count(*) from loglogin where userid='$this->userid' AND logouttime IS NOT NULL";
	    //$this->totalNumPages = ceil($this->conn->query($query)->fetchColumn());
	    /*$sql = "select * from loglogin where userid='$this->userid' AND logouttime IS NOT NULL ORDER BY logintime DESC limit $this->startPage, 1 ";
            $result = $this->conn->query($sql);
            foreach($result as $row)
	    {
               $userip = $row['ip'];
               $logintime = $row['logintime'];
               $logouttime = $row['logouttime']; 
	    */
			
                
            $query = "select * from accesslog where ip='$this->userip' and timestamp >= '$this->logintime' and timestamp <= '$this->logouttime' ORDER BY timestamp DESC";

                                
            foreach($this->conn->query($query) as $line)
	    {
                $timestamp = $line['timestamp'];
                $timestamp = Utility::getTimeString($timestamp);
                $size = $line['size'];
                $url =  $line['url'];
                $mime = $line['mime'];
                    
                //full up each line
                $list = array($timestamp, $size, $url, $mime);
                //$this->userLogHTML .= fillUpList($list);
                $td_class = array("timestamp", "size", "url", "mime");
                $tableRow =  "<tr>";
                $i = 0;
     
                   foreach($list as $element)
		   {
                      $tableRow .= "<td class='$td_class[$i]'><code>$element</code></td>";
                      $i++;
                   }
                   
		$tableRow .= "</tr>\n";
                $this->userLogHTML .= $tableRow;
               
	    }
           
	   // }
        
			
	    $view_logintime = Utility::getTimeString($this->logintime);
	    $view_logouttime = Utility::getTimeString($this->logouttime);

            return array($this->userLogHTML, $view_logintime, $view_logouttime);
 
	}
	
	
	
	
	public function getUserLogListHTML()
	{


	   $this->userLogListHTML = "";
		
		        
	   $sql = "select * from loglogin where userid='$this->userid' AND logouttime IS NOT NULL ORDER BY logintime DESC";
		 
		 
	   $result = $this->conn->query($sql);
	   
	   foreach($result as $row)
	   { 
	      $userip = $row['ip'];
			 
	      $logintimeLink = $row['logintime'];
	      $logouttimeLink = $row['logouttime']; 
		 
	      $logintime = Utility::getTimeString($row['logintime']);
	      $logouttime = Utility::getTimeString($row['logouttime']); 
		 
	      // full up each line
	      $list = array($userip, $logintime, $logouttime);

	      $td_class = array("userip", "logintime", "logouttime");
	      $tableRow =  "<tr>";
	      $i = 0;
	      
	      foreach($list as $element)
	      {
		 $tableRow .= "<td class='$td_class[$i]'><div align='center'><code><a href='logUser.php?userid=".$this->userid."&logintime=".$logintimeLink."&logouttime=".$logouttimeLink."&userip=".$userip."'> ".$element ."</a></code></div></td>";

		 $i++;
	      }
		
	      $tableRow .= "</tr>\n";
	      $this->userLogListHTML .= $tableRow;
	   }
	

	
	    return array($this->userLogListHTML);

	}
	

    }

?>