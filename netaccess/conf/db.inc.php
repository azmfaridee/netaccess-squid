<?php
    
    
    $config_server_ip = "your_server_ip_address";

    $config_docroot = "http://" .$config_server_ip . "/netaccess/";

    $squid_log_path = "/var/log/squid3/access.log";
    
    $config_currency = "TK.";

    $db_host = "your_database_host";
    $db_user = "your_database_user";
    $db_pass = "your_database_pass";
    $db_name = "netaccess";		//change if require

    /****************************************************************
    warning: also make change in the PDO_connection class scroll down
    *****************************************************************/


    $conn = mysql_connect($db_host, $db_user, $db_pass) or die("Cannot connect");
    mysql_select_db($db_name, $conn);
    

    //PDO class
    class PDO_connection
    {                
	public $dbh;
         
        function getConnection()
        {
	   
	   $db_host = "your_database_host";
    	   $db_user = "your_database_user";
    	   $db_pass = "your_database_pass";
    	   $db_name = "netaccess";
 	    
	   
	    try {
		   //create PDO connection
		   $dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass, array( PDO::ATTR_PERSISTENT => true));
                        
                   //set arrtibute for debugging
                   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                   // echo "Connected";
		
            	} catch (PDOException $pe) {
                        
                	print "Error!: " . $pe->getMessage() . "<br/>";
                	die();
            	}
		
	    return $dbh;
        }

    }
?>