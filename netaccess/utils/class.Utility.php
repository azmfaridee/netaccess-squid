<?php

/*
 * Please Put all your utility function in this class as static functions
 */
  
    class Utility
    {
        public static function getCurrentTimeStamp()
	{
            $time_data =  preg_split("/[\s]+/", microtime());
            $current_time = $time_data[1] . substr($time_data[0], 1, 4);
            return $current_time;
        }

        
        public static function getTimeString($timeStamp = 0)
	{
            if($timeStamp == 0)
	    {
                $logintime = date("Y-m-d H:i:s");                
            }
	    else
	    {
                $logintime = date("Y-m-d H:i:s", $timeStamp);                
            }
            
	    return $logintime;
        }
        

        public static function generateSafeQuery($value)
	{
            if(get_magic_quotes_gpc())
	    {
                $value = stripslashes($value);
            }

            $value = mysql_real_escape_string( $value );
            return $value;
        }
    }

?>