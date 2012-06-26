<?php
session_start();

$currusr=md5($_SERVER['HTTP_USER_AGENT']. $_SERVER['REMOTE_ADDR']);

if (empty($_SESSION['user_hash'])) {
    session_destroy();
    header("location:../../index.php");	
}

if (strcmp($_SESSION['user_hash'], $currusr) !==0) {
    session_regenerate_id();
    $_SESSION= array();
    $_SESSION['user_hash']=$currusr;	
    header("location:../../index.php");
}

$usr= $_SESSION['user'];

require('../php/connection.php');

$dbh = DB_connect_Bartool();

$SQL = "SELECT count(ID) FROM dbo.tbl_ErrorLog WHERE datepart(month,getdate())" 
    ."= datepart(month,ClosedOn)AND datepart(year,getdate()) = datepart(year,ClosedOn) AND ErrorByParty IN ('COS','MCBC & HP', 'HP')";
$qry = $dbh->prepare($SQL);
$qry->execute();

$errVol = "";

while ($row = $qry->fetch(PDO::FETCH_NUM)) {
    $errVol = $row[0];
}
unset($qry);

$SQL="SELECT count(TicketID) FROM dbo.TRACKER
WHERE Open_Time > 30
AND Ticket_status_Start <> 'Resolved'";

$qry=$dbh->prepare($SQL);
$qry->execute();

$over30 = "";

while ($row = $qry->fetch(PDO::FETCH_NUM)) {
    $over30 = $row[0];
}
unset($qry);
unset($dbh);
?>

<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script language="javascript" type="text/javascript" src="../js/jquery-1.7.2.js"></script>
        <script language="javascript" type="text/javascript" src="../js/excanvas.min.js"></script>
        <script language="javascript" type="text/javascript" src="../js/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jqplot.barRenderer.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jqplot.pointLabels.min.js"></script>
        <script type="text/javascript" src="../js/jquery.corner.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/jquery.jqplot.css" />
        <link rel="stylesheet" type="text/css" href="../css/dashboardStyle.css" />
        <title>Hermes reporting tool - dashboard</title>
    </head>
    <body>
        <div>
        <div id="header">
            <p>You're viewing MCBC details. To switch to BEHR <a href="">click here</a>.<br/>
            You're logged on as: <?php echo($usr); ?><br/>    
            Click to <a href="../php/logout.php">logoff</a>.</p>
        </div>
            </div>    
        <div id="wrapper">
            <div id="menu">
                <table id="tblMenu">
                    <tr class="header"><td>Menu</td></tr>
                    <tr><td><a href="bartool_IM.php">Bartool Metrics</a></td></tr>
                </table>
            </div>
            <div id="container">
                <img src="../../img/logo-molson-coors.gif"/>
                <h1 class="headings">Hermes reporting platform</h1>
<!--                <div id="chart1"></div>
                <div id="afterTATVol"></div>
                <div id="fnaVol"></div>
                <div id="textVolInfo"><hr/>
                Number of HP errors this month: <span class="highlight"><?php echo($errVol);?></span><br/>
                Number of cases pending more than 30 days: <span class="highlight"><?php echo($over30);?></span>
                <hr/>
                </div>-->
                
            </div>
        </div>
    <script src="../js/charts.js"></script>

    </body>
</html>