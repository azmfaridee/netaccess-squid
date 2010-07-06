#!/usr/bin/php
<?php

    require_once('/var/www/netaccess/conf/db.inc.php');


    // 15 minutes back from now on update loggedin set
    $time_now = time();
    $time_check = $time_now - 1800;
    
    $sql_loglogin = "select * from loglogin where logouttype is NULL or logouttime is NULL";
    $result_loglogin = mysql_query($sql_loglogin, $conn);

    // for each record in loglogin where there is evidence that user has not logged out
    while($array_loglogin = mysql_fetch_assoc($result_loglogin))
    {
         $userid = $array_loglogin['userid'];
         $ip = $array_loglogin['ip'];
         $logintime = $array_loglogin['logintime'];
        
          // now check if that user is currently logged in logged in table
         $sql_loggedin = "select * from loggedin where userid='$userid' and ip='$ip' and time='$logintime'";
         $result_loggedin = mysql_query($sql_loggedin, $conn);
 
         if(mysql_num_rows($result_loggedin) > 0) // valid found
	 {
              // we need to check for inactivity
              $sql_accesslog = "select * from accesslog where ip='$ip' and timestamp>'$time_check'";
              $result_accesslog = mysql_query($sql_accesslog, $conn);

              if(mysql_num_rows($result_accesslog) > 0)
	      {
                  // user is valid so do not do anything
              }
	      else  // need to kick out that user
	      {
                  // clear logged in
                  $sql_update_loggedin = "delete from loggedin where ip='$ip' and userid='$userid'";
                  mysql_query($sql_update_loggedin, $conn);
  
                  // update loglogin
                  //$time_to_logout = $logintime + 1800;
                  $sql_loglogin_fix = "update loglogin set logouttime='$time_now', logouttype='kickout' where userid='$userid' and ip='$ip' and logintime='$logintime'";
                  mysql_query($sql_loglogin_fix);
              }

        }
	else  // anomalie found, just fix that
	{
              //$time_to_logout = $logintime + 1800;
              $sql_loglogin_fix = "update loglogin set logouttime='$time_now', logouttype='kickout' where userid='$userid' and ip='$ip' and logintime='$logintime'";
              mysql_query($sql_loglogin_fix);
        }

    }
?>