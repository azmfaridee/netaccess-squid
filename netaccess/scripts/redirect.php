#!/usr/bin/php
<?php

   require_once('/var/www/netaccess/conf/db.inc.php');
   
   $temp = array();
   
   while ($input = fgets(STDIN)) 
   {
	// Split the output (space delimited) from squid into an array.
	$temp = split(' ', $input);

	// Set the URL from squid to a temporary holder.
	//$output = $temp[0] . "\n";

	// Clean the Requesting IP Address field up.
	$ip = rtrim($temp[1], "/-");

	//redirect to login
	$output = "302:".$config_docroot."/user/\n";


	// Check the URL and rewrite it if it matches limewire.com
	//to allow to view the login page
	if (strpos($temp[0], $config_server_ip)) 
	{
	   $output =  $temp[0] . "\n";	 //temp[0] containing the original url
	}

	//check if the user currently logged in
	$sql =  "select count(*) from loggedin where ip='$ip'";
	$res = mysql_query($sql,$conn) or die("Having error in execution 2==".mysql_error());
	list($usr) = mysql_fetch_row($res);


	if($usr==1) 
	{
	   $output =  $temp[0] . "\n";	 //temp[0] containing the original url
	}

	echo $output;
   }
?>