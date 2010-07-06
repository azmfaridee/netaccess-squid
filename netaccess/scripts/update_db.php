#!/usr/bin/php
<?php

    require_once('/var/www/netaccess/conf/db.inc.php');
 

    $contents = file_get_contents($squid_log_path); //defined in db.inc.php

    
    $splitted_contents = preg_split("/[\s]+/", $contents);
    $access_log = array_chunk($splitted_contents, 10);
    array_pop($access_log);
    
    $sql = "select max(timestamp) from accesslog";
    $result = mysql_query($sql, $conn);

    if(mysql_num_rows($result) > 0) // Max result has been found
    {
        $max_timestamp = mysql_result($result, 0);

        for($i=0; $i<count($access_log); $i++)
	{
            if($max_timestamp == $access_log[$i][0])
	    {
                break;
            }
        }

        if($i == count($access_log)) // max_timestamp was not found in the file, as loop has reached the end of access_log
	{
            $i=0;
        }
	else // we will start inserting next from the matching timestamp's position
	{
            $i++;
        }

    }
    else // Database empty, dump the whole file into database
    {
        $i =0;
    }

    for(; $i<count($access_log); $i++)
    {
        list($timestamp, $delay, $ip, $tcp_code, $size, $action, $url, $blank, $director, $mime) = $access_log[$i];
        $sql = "insert into accesslog values('$timestamp', '$delay', '$ip', '$tcp_code', '$size', '$action', '$url', '$blank', '$director', '$mime')";
        mysql_query($sql, $conn) or die(mysql_error($conn));
    }
    
    mysql_close($conn);
?>