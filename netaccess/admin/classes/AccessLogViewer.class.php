<?php

    require_once('../utils/class.Utility.php');
    
    class AccessLogViewer
    {
        private $conn;
        private $accessLogHTML;
        private $startPage;
        private $itemsPerPage;
        
        private $totalNumPages;
        
        public function __construct($conn, $page_no = 1, $items_per_page = 20)
	{
            $this->conn  = $conn;
            $this->itemsPerPage = $items_per_page;
            $this->startPage = ($page_no - 1) * $this->itemsPerPage;
        }
       
        public function getAccessLog()
	{
            $this->accessLogHTML = "";
            
            $sql = "select count(*) from accesslog";
            $this->totalNumPages = ceil($this->conn->query($sql)->fetchColumn() / $this->itemsPerPage);

	    //$sql = "select * from accesslog ORDER BY timestamp DESC limit $this->startPage, $this->itemsPerPage";
            $sql = "select timestamp, delay, ip, size, action, url, blank, director, mime from accesslog ORDER BY timestamp DESC limit $this->startPage, $this->itemsPerPage";
            $stmt  = $this->conn->prepare($sql);
	    //$td_class = array("timestamp", "delay", "ip", "tcp_code", "size", "action", "url", "blank", "director", "mime");
            $td_class = array("timestamp", "delay", "ip", "size", "action", "url", "blank", "director", "mime");

            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	    {
                $logRow = "";
                $row['timestamp'] = Utility::getTimeString($row['timestamp']);
                //list($timestamp, $delay, $ip, $tcp_code, $size, $action, $url, $blank, $director, $mime) = $row;
                $i = 0;
                foreach($row as $cellData)
		{
                    $logRow .= "<td class='$td_class[$i]'><code>$cellData</code></td>\n";
                    $i++;
                }
                $this->accessLogHTML .= "<tr><code>$logRow</code></tr>\n";           
            }
            return array($this->accessLogHTML, $this->totalNumPages);
        }
    }

?>