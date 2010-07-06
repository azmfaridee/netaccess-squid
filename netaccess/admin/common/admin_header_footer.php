<style type="text/css">

#header{
    position: relative;
    width: 800px;
}    

#footer{
    position: relative;
    width: 800px;
}

#header table{
    z-index: 100;
    position: fixed;
    top: 0px;
    width: 100%;
    caption-side: bottom;
    border-collapse: collapse;
    border: 1px solid #FFFFFF;
}

#header table th {
    height: 40px;
    background: #b9d9f3;
    color: white;
}

#footer table{
    z-index: 100;
    position: fixed;
    bottom: 0px;
    width: 100%;
    caption-side: bottom;
    border-collapse: collapse;
    border: 1px solid #FFFFFF;
}

#footer table th {
    background: #cccccc;
    color: white; 
}

#header table a{
    color: white;
    font-style: normal;
}

</style>

<script type="text/javascript"></script>

<?php
    
    function header_generator($config_docroot)
    {

	//$config_server_adminroot = "http://172.20.0.1/netaccess/admin";
	//$config_server_adminroot = $config_docroot."/admin";
	$config_server_adminroot = $config_docroot."admin";

        $header_text = "";
        $header_text .= "<th><a href=\"$config_server_adminroot/index.php\">Admin Home</a></th>";
        $header_text .= "<th><a href=\"$config_server_adminroot/regUser/adduser.php\">Add Users</a></th>";
        $header_text .= "<th><a href=\"$config_server_adminroot/showUser/showuser.php\">Edit/Remove User</a></th>";
        $header_text .= "<th><a href=\"$config_server_adminroot/bandWidthUser/bandWidthUserList.php\">View user bandwidth</a></th>";
        $header_text .= "<th><a href=\"$config_server_adminroot/bandwidthCostConfig/bandwidthCostConfig.php\">Bandwidth & Cost Config</a></th>";
        $header_text .= "<th><a href=\"$config_server_adminroot/viewlog.php?page_no=1\">View Complete Usage Log</a></th>";
        $header_text .= "<th><a href=\"$config_server_adminroot/editAdmin/editAdmin.php\">Edit admin</a></th>";
        return $header_text;
    }
    
    
    function add_header($config_docroot)
    {
?>
	<div align="center" id="header">
    	   <table cellspacing="2" cellpadding="0">
              <thead></thead>
 	      <?php
		  echo header_generator($config_docroot);
    	      ?>
    	   </table>
	</div>
<?php
   
   }


   function add_footer()
   {

?>
	<div align="center" id="footer">
    	   <table>
    	      <thead>
       	         <th>Net Access Squid</th>
    	      </thead>
    	   </table>
	</div>
<?php

  }

?>
