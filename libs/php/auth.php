<?php
require 'connection.php';

$dbh = DB_connect_Bartool();

$usr = $_POST['logon'];
$pass = $_POST['pass'];

$SQL = "SELECT Count(UserName) FROM tHermesUsr WHERE UserName ='" .$usr 
         . "' AND UsrPassword='" .$pass ."'";

$qry = $dbh->prepare($SQL);
$qry->execute();

while ($row = $qry->fetch(PDO::FETCH_NUM)) {
    $result = $row[0];
}

If($result === '1'){
    session_start();
    $userHash = md5($_SERVER['HTTP_USER_AGENT']. $_SERVER['REMOTE_ADDR']); 
    $_SESSION['user_hash']=$userHash;
    $_SESSION['user'] = $usr;
    header("location:../www/dashboard.php");
} else {
    echo('Incorrect User Name/Password!<br/> Please click <a href="../../index.php">here</a> to return to login screen.');
}
?>
