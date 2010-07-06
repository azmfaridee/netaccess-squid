<?php

    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        require_once('classes/AccessLogViewer.class.php');
        require_once('../conf/db.inc.php');
        require_once('common/admin_header_footer.php');
    
        $page_no = $_REQUEST['page_no'];
    
        $pdoConnection = new PDO_connection();
        $conn = $pdoConnection->getConnection();
        $accessLogViewer = new AccessLogViewer($conn, $page_no, 20);
        list($accessLogHtml, $totalNumPages) = $accessLogViewer->getAccessLog();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Access Log</title>


    <style>

    table {
        table-layout: fixed;
        caption-side: bottom;
        border-collapse: collapse;
        border: 1px solid #FFFFFF;
    }

    table td, table th {
        padding: 2px;        
    }

    table th {
        background: #b9d9f3;
        color: white; 
    }
    
    .timestamp{
        word-break: break-all;
        width: 100px;
    }

    .delay{
        word-break: break-all;
        width: 50px;
        text-align: right;
    }

    .ip{
        word-break: break-all;
        width: 100px;
    }

    .tcp_code{
        word-break: break-all;
        width: 100px;
    }

    .size{
        word-break: break-all;
        width: 100px;
        text-align: right;
    }

    .action{
        word-break: break-all;
        width: 60px;
    }

    .url{
        word-break: break-all;        
    }

    .blank{
        word-break: break-all;
        width: 20px;
    }

    .director{
        word-break: break-all;
        width: 200px;
    }

    .mime{
        word-break: break-all;
        width: 100px;
    }
     
    </style>


    <script type="text/javascript">

        function clickedPrev()
	{
            var page_no = <?php echo $page_no;?>;
            if(page_no > 1)
	    {
                page_no--
            }
            window.location = "./viewlog.php?page_no=" + page_no
        }

        function clickedNext()
	{
            var page_no = <?php echo $page_no;?>;
            var totalNumPages = <?php echo $totalNumPages; ?>;
            if(page_no < totalNumPages)
	    {
                page_no++;
            }
            window.location = "./viewlog.php?page_no=" + page_no
        }

        function mouseFocus(id)
	{
            document.getElementById(id).setAttribute("style", "cursor:pointer");
        }

    </script>


</head>
<body>

   <?php
       add_header($config_docroot);
   ?>

   <br/><br/><br/>

   <div align="center">
      Page <?php echo $page_no; ?> of <span id="totalNumPages">0</span>
   </div>

   <script>
    document.getElementById("totalNumPages").innerHTML = <?php echo $totalNumPages;?>
   </script>

   <div align="Center">
    <u>
       <a id="linkPrev" onclick="clickedPrev()" onmouseover="mouseFocus('linkPrev')">Prev Page</a>
    </u>/
    <u>
       <a id="linkNext" onclick="clickedNext()" onmouseover="mouseFocus('linkNext')">Next Page</a>
    </u>

   </div>

   <br/>

   <table style="width:100%">
      <thead>
	<th class="timestamp">Time Stamp</th>
	<th class="delay">Delay</th>
	<th class="ip">IP</th>
	<!--<th class="tcp_code">TCP Code</th>-->
	<th class="size">Size</th>
	<th class="action">Method</th> 
	<th class="url">URL</th>
	<th class="blank">-</th>
	<th class="director">Director</th>
	<th class="mime">MIME Type</th>
      </thead>
      <tbody>
	<?php
	   echo $accessLogHtml;
      	?>
      </tbody>
  </table>

  <br />

  <?php
     add_footer();
   ?>

</body>
</html>

<?php        

    }
    else
    {
	header('Location:index.php');
    }
?>