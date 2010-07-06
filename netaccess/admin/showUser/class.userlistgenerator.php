<?php

    class UserListGenerator
    {

        private $conn;
        private $userList;
        
        private $username;
        private $userid;
        private $password;
        private $roomno;
        private $logged_in;
        
        public function __construct($conn)
	{
            $this->conn = $conn;
        }
        
        public function getUserList()
	{
            $this->userList = "";
            try{
                $sql = "select * from user where status='1'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $stmt->bindColumn('username', $this->username);
                $stmt->bindColumn('userid', $this->userid);
                $stmt->bindColumn('password', $this->password);
                $stmt->bindColumn('roomno', $this->roomno);
                // $stmt->bindColumn('logged_in', $this->logged_in);
                
                while($stmt->fetch(PDO::FETCH_BOUND))
		{
                    $this->userList .= "<tr>";
                    $this->userList .= "<td> &nbsp; $this->userid  &nbsp; </td>";
                    $this->userList .= "<td> &nbsp; $this->username &nbsp; </td>";
                    $this->userList .= "<td> &nbsp; $this->roomno &nbsp; </td>";
                    $this->userList .= "<td> &nbsp; ";
                   
                                        
                    //get the login information from the loggedin table
                    $sql_getlogin = "SELECT ip FROM loggedin WHERE userid='$this->userid'";
                    $resultSet = $this->conn->query($sql_getlogin);
                                        
                    if($resultSet->fetchColumn() > 0)
		    {
                                                
                        $row =  $this->conn->query($sql_getlogin)->fetch(PDO::FETCH_ASSOC);
                        $userip= $row['ip'];
                        $this->userList .= "$userip";
                    } 
		    else 
		    {
                        $this->userList .= "---";
                    }
                                         
                                        
                                        
                    /*if($this->logged_in == '1'){
                        $this->userList .= "Yes";
                    }else{
                        $this->userList .= "No";
                    }
                     */
                                        
                    $this->userList .= " &nbsp; </td>";
                    $kickUserLink = "../kickUser/kickUser.php?userid=$this->userid";
                    $editUserLink = "../editUser/editUser.php?userid=$this->userid";
                    $deleteUserLink = "../deleteUser/deleteUser.php?userid=$this->userid";
                    //$logUserLink = "../logUser/logUser.php?userid=$this->userid&page_no=1";
                    $logUserLink = "../logUser/logUser.php?userid=$this->userid";
                    $bandWidthUserLink = "../bandWidthUser/bandWidthUserList.php?userid=$this->userid";
                    // $this->userList .= "<td><a href=../kickUser/kickUser.php?userid=$this->userid>Kick</a>/<a href=../editUser/editUser.php?userid=$this->userid>Edit</a>/<a href=../deleteUser/deleteUser.php?userid=$this->userid>Delete</a>/<a href=../logUser/logUser.php?userid=$this->userid>View Log</a></td>";
                    $this->userList .= "<td> &nbsp; <a href=$kickUserLink>kick</a> &nbsp; <a href=$editUserLink>edit </a> &nbsp; <a href=$deleteUserLink>del</a> &nbsp; <a href=$logUserLink>log</a> &nbsp; <a href=$bandWidthUserLink>bandwidth</a> &nbsp; </td>";
                    $this->userList .= "</tr>";
                }
            } 
	    catch(PDOException $pe)
	    {
                echo "Failed: " . $pe->getMessage();
            }
            return $this->userList;
        }
    }
?>