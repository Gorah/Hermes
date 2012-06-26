<?php

function DB_connect(){
   $serverName = "BPOPLMCBC16"; 
   $database = "AdminTracker_SQL";

   // Get UID and PWD from application-specific files. 
   $uid = "AppLogon";
   $pwd = "InisMona2010";

   try {
      $dbh = new PDO( "sqlsrv:server=$serverName;Database = $database", $uid, $pwd); 
      $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
   }

   catch( PDOException $e ) {
    die( "Error connecting to SQL Server" ); 
   }
   
   return $dbh;
}

function DB_connect_Bartool(){
   $serverName = "BPOPLMCBC16"; 
   $database = "BartoolSQL";

   // Get UID and PWD from application-specific files. 
   $uid = "AppLogon";
   $pwd = "InisMona2010";

   try {
      $dbh = new PDO( "sqlsrv:server=$serverName;Database = $database", $uid, $pwd); 
      $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
   }

   catch( PDOException $e ) {
    die( "Error connecting to SQL Server" ); 
   }
   
   return $dbh;
}
?>
