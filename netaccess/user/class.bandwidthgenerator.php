<?php
/**
 * PHP Template.
 */
    class BandwidthGenerator
    {
        private $conn;
        private $username;
        private $userid;
        private $ip;
        private $logintime;
        private $logouttime;
        
        private $userBandWidth;
	private $config_currency;      

        function __construct($conn, $userid, $config_currency)
	{
            $this->conn = $conn;
            $this->userid = $userid;
	    $this->config_currency = $config_currency;
        }
        
            
        function getUserBandwidth()
	{
           
            $this->userBandWidth = "";                
            //$this->userBandWidth = "";
            
            try{
                                
                
  		$sql = "select * from user where userid='$this->userid' AND status='1'";
	                                
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                                
                $stmt->bindColumn('username', $this->username);
                $stmt->bindColumn('userid', $this->userid);
                        
                while($stmt->fetch(PDO::FETCH_BOUND))
		{
                 
		    $sql_loglogin = "select * from loglogin where userid='$this->userid' AND logouttime IS NOT NULL;";
                    $stmt_loglogin = $this->conn->prepare($sql_loglogin);
                    $stmt_loglogin->execute();
                    //$stmt_loglogin->bindColumn('userid', $this->userid);
                    $stmt_loglogin->bindColumn('ip', $this->ip);
                    $stmt_loglogin->bindColumn('logintime', $this->logintime);
                    $stmt_loglogin->bindColumn('logouttime', $this->logouttime);
                
                                    
                    //set size initially 0 ***********
                    $size = 0;
                                      
                                        
                    while($stmt_loglogin->fetch(PDO::FETCH_BOUND))
		    {                    
                       //get the login information from the loggedin table
                       //$sql_getlogin = "SELECT ip FROM loggedin WHERE userid='$this->userid'";
                                        
                        $sql_bandwidth = "SELECT SUM(size) AS size FROM accesslog WHERE timestamp>'$this->logintime' AND timestamp<'$this->logouttime' AND ip='$this->ip'";
			$stmt_bandwidth = $this->conn->prepare($sql_bandwidth);
			$stmt_bandwidth->execute();
			$stmt_bandwidth->bindColumn('size', $tmp_size);
			
			while($stmt_bandwidth->fetch(PDO::FETCH_BOUND))
			{
			   $size = $size + ($tmp_size/1048576);
								
			}

                        //$resultSet = $this->conn->query($sql_bandwidth);
                        //if($resultSet->fetchColumn() > 0){ 
                        //$row =  $this->conn->query($sql_bandwidth)->fetch(PDO::FETCH_ASSOC);
                        //$size = $row['size'];
                        //$this->userBandWidth .= "$size";             
                        //} else {
                           //$this->userBandWidth .= "0";
                            //size += 0;
                        // }                        
                        // $size += $row['size'];                                                
                                        
                    }
                                        
					
	   	    //get the free bandwidth and price
  		    //get maxtime
		    $sql_max_timestamp = "SELECT MAX(timestamp) AS timestamp FROM config";
		    $row =  $this->conn->query($sql_max_timestamp)->fetch(PDO::FETCH_ASSOC);
		    $max_timestamp = $row['timestamp'];
				
		    //get data from the last timestamp
		    $sql_free_bandwidth_with_price = "SELECT * FROM config where timestamp='$max_timestamp'";
		    $row =  $this->conn->query($sql_free_bandwidth_with_price)->fetch(PDO::FETCH_ASSOC);
		    $free_bandwidth = $row['free_bandwidth'];
		    $price_per_mb = $row['price_per_mb'];
					
					
				
		    // round up to 2 fraction
		    $size = round($size, 2);
			
		    $remaining_bandwidth = $free_bandwidth - $size;
			
		    if($remaining_bandwidth <= 0)
		    {
			$cost = ($size - $free_bandwidth) * $price_per_mb;
		    }
		    else
		    {
			$cost = 0;
		    }
			
		    $sizeDenote = "MB";

					
		    $this->userBandWidth .= "Bandwidth usage: &nbsp; $size &nbsp; $sizeDenote &nbsp;";
		    $this->userBandWidth .= "<br />Remaining bandwidth: $remaining_bandwidth &nbsp; $sizeDenote &nbsp;";
   		    $this->userBandWidth .= "<br /><br />Total costs: $cost &nbsp;".$this->config_currency." &nbsp;";
			
		
		    /*
   		      $this->userBandWidth .="<table border='0'>";
		      $this->userBandWidth .= "<tr><td>Bandwidth usage: </td><td>&nbsp; $size &nbsp; $sizeDenote &nbsp;</td></tr>";
		      $this->userBandWidth .= "<tr><td>Remaining bandwidth: </td><td> &nbsp; $remaining_bandwidth &nbsp; $sizeDenote &nbsp;</td></tr>";
		      $this->userBandWidth .= "<tr><td>Total costs: </td><td> &nbsp; $cost &nbsp;".$this->config_currency." &nbsp;</td></tr>";
		      $this->userBandWidth .="</table>";
			*/

                }
 
              }catch(PDOException $pe){
                echo "Failed: " . $pe->getMessage();
              }
          
	  return $this->userBandWidth;
                        
        }
    }
?>