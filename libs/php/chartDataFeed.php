<?php
require "./connection.php";
    $dbh = DB_connect();

    date_default_timezone_set('UTC'); 
    
    $SQL = "SELECT * FROM vw_IM_Over30";
    $qry = $dbh->prepare($SQL);
    $qry->execute();

    while ($row = $qry->fetch(PDO::FETCH_NUM)) {
        $more30 = $row[0];
        $less30 = $row[1];
    }

    unset($qry);
    unset($dbh);
    
    $json = '{"more30":"' .$more30 . '", "less30":"' .$less30 .'"';
    
//Building $dbh database connection object for Bartool
    $dbh=DB_connect_Bartool();
//Fetching data about Open Cases Volume for Bartool    
    $SQL = "SELECT * FROM vw_IM_OpenCases ORDER BY Ticket_open_datetime ASC";
    $qry = $dbh->prepare($SQL);
    $qry->execute();

    $dates = "";
    $volumes = "";

//    Building string for JSON transport
    while ($row = $qry->fetch(PDO::FETCH_NUM)) {
        $dates = $dates ."'" .date('Y-m-d',strtotime($row[0])) ."'" .",";
        $volumes= $volumes .$row[1] .", ";
    }
//removing leftover space and "," from the end of the strings
    $dates = substr($dates, 0, -2);
    $volumes = substr($volumes, 0, -2);
//    cleasring $qry PDO object for reusage
    unset($qry);

//  Fetching info about cases closed volume anc preparing string for JSON    
    $SQL = "SELECT * FROM vw_IM_casesClosed";
    $qry = $dbh->prepare($SQL);
    $qry->execute();
    
    $jsonBit = "";
    while ($row = $qry->fetch(PDO::FETCH_NUM)) {
        $jsonBit = $jsonBit .'"' ."'" .date('Y-m-d',strtotime($row[0])) ."'" .'":"' .$row[1] .'",';
    }
    
    unset($qry);
    
    $SQL = "SELECT a.Ticket_close_datetime FROM (SELECT DISTINCT TOP 10"
        . " Ticket_close_datetime FROM TRACKER ORDER BY Ticket_close_datetime"
        . " DESC) as a ORDER BY a.Ticket_close_datetime ASC";
    $qry=$dbh->prepare($SQL);
    $qry->execute();
    
    $headerDates = "";
    
    while ($row=$qry->fetch(PDO::FETCH_NUM)) {
        $headerDates = $headerDates ."'" .date('Y-m-d',strtotime($row[0])) ."'" .",";
    }
    
    $headerDates = substr($headerDates, 0, -2);
    unset($qry);
    
    $SQL = "SELECT * FROM vw_IM_afterTAT";
    $qry = $dbh->prepare($SQL);
    $qry->execute();
    
    $jsonATAT = "";
    
    while ($row = $qry->fetch(PDO::FETCH_NUM)) {
        $jsonATAT = $jsonATAT .'"' ."'" .date('Y-m-d',strtotime($row[0])) ."'" .'":"' .$row[1] .'",';
    }
    unset($qry);
    
    $SQL = "SELECT * FROM vw_IM_FNA ORDER BY Ticket_open_datetime ASC";
    $qry = $dbh->prepare($SQL);
    $qry->execute();
    
     $fnaDates = "";
     $fnaVolumes= "";
    
    while ($row = $qry->fetch(PDO::FETCH_NUM)) {
        $fnaDates = $fnaDates ."'" .date('Y-m-d',strtotime($row[0])) ."'" .",";
        $fnaVolumes= $fnaVolumes .$row[1] .", ";
    }
//removing leftover space and "," from the end of the strings
    $fnaDates = substr($fnaDates, 0, -2);
    $fnaVolumes = substr($fnaVolumes, 0, -2);
    
//    final clearing of the objects
    unset($qry);
    unset($dbh);
    
    $jsonBit = substr($jsonBit,0,-1);
    $jsonATAT = substr($jsonATAT,0,-1);
//    dodac nested jsona z danymi z jsonBit, a potem w JS przeparsowac wszystko i zrobic porownanie 
//    - jesli key z ticks jest w subjsonie, to przypisac wartosc. jesli nie, to wartosc = 0
//    jesli tak, przypasowac wartos. Potem ciagi wrzucic do jplota na zasadzie [open1, open2, open3], [close1, close2, close3]
    $json = $json . ',"dates":"' .$dates . '","volumes":"' .$volumes .'","dailyClosed":' .'[{' .$jsonBit .'}],"TATdates":"' 
            .$headerDates .'","TATdet":[{' .$jsonATAT.'}],"fnaDates":"' .$fnaDates 
            . '","fnaVols":"' . $fnaVolumes .'"}';
    echo($json);
?>
