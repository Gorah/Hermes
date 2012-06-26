<!DOCTYPE html>
<?php
require "./libs/php/connection.php";
$dbh = DB_connect();

$SQL = "SELECT * FROM vw_IM_Over30";
$qry = $dbh->prepare($SQL);
$qry->execute();

while ($row = $qry->fetch(PDO::FETCH_NUM)) {
    $more30 = $row[0];
    $less30 = $row[1];
}

unset($qry);
unset($dbh);

$dbh=DB_connect_Bartool();
$SQL = "SELECT * FROM vw_IM_OpenCases";
$qry = $dbh->prepare($SQL);
$qry->execute();

$dates = "[";
$volumes = "[";

while ($row = $qry->fetch(PDO::FETCH_NUM)) {
    $dates = $dates ."'" .date('Y-m-d',strtotime($row[0])) ."'" .", ";
    $volumes= $volumes .$row[1] .", ";
}

$dates = substr($dates, 0, -2) ."]";
$volumes = substr($volumes, 0, -2) ."]";


?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="./libs/js/excanvas.min.js"></script><![endif]-->
        <script language="javascript" type="text/javascript" src="./libs/js/jquery-1.7.2.js"></script>
        <script language="javascript" type="text/javascript" src="./libs/js/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="./libs/js/plugins/jqplot.barRenderer.min.js"></script>
        <script type="text/javascript" src="./libs/js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="./libs/js/plugins/jqplot.pointLabels.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./libs/css/jquery.jqplot.css" />
        <link rel="stylesheet" type="text/css" href="./libs/css/style.css" />
        <title>Hermes reporting tool</title>
    </head>
    <body><h1 style="text-align: center;">Admin Tracker Metrics</h1>
        <div id="Over30chart" style ="height: 300px;width: 800px;"></div>
        <br/>
        <h1 style="text-align: center;">Bartool Metrics</h1>
        <div id="dailyOpened" style ="height: 300px;width: 800px;"></div>
        <script>
            $(document).ready(function(){
    // For horizontal bar charts, x an y values must will be "flipped"
    // from their vertical bar counterpart.
       var plot1 = $.jqplot('Over30chart', [
        [[<?php echo($less30); ?>,1]],[[<?php echo($more30); ?>,1]]], {
//        stackSeries: true,
        title: 'Pending Cases breakdown',
        series: [{color: '#00EE00', label: 'Under 30 days'}, {color: '#FF2400', label:'Over 30 days'}],
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            // Show point labels to the right ('e'ast) of each bar.
            // edgeTolerance of -15 allows labels flow outside the grid
            // up to 15 pixels.  If they flow out more than that, they 
            // will be hidden.
            pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
            // Rotate the bar shadow as if bar is lit from top right.
            shadowAngle: 135,
            // Here's where we tell the chart it is oriented horizontally.
            rendererOptions: {
                barDirection: 'horizontal',
                barWidth: 50
            }
        },
        axes: {
            yaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ['awewewewa', 'bb']
            }
        },
        legend: {
              show: true,
              location: 'e',
              placement: 'outside'
    }      
    });
    
     var s1 = <?php echo($volumes);?>;
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
    var ticks = <?php echo($dates);?>;
     
    var plot1 = $.jqplot('dailyOpened', [s1], {
        // The "seriesDefaults" option is an options object that will
        // be applied to all series in the chart.
        title: 'Open Cases - daily breakdown',
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true},
            pointLabels: { show: true, location: 'n', edgeTolerance: -15 }
        },
        // Custom labels for the series are specified with the "label"
        // option on the series option.  Here a series option object
        // is specified for each series.
        series:[
            {label:'Open Cases', color:'#00FF7F'}
        ],
        // Show the legend and put it outside the grid, but inside the
        // plot container, shrinking the grid to accomodate the legend.
        // A value of "outside" would not shrink the grid and allow
        // the legend to overflow the container.
        legend: {
            show: true,
            placement: 'outside',
            location: 'e'
        },
        axes: {
            // Use a category axis on the x axis and use our custom ticks.
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },
            // Pad the y axis just a little so bars can get close to, but
            // not touch, the grid boundaries.  1.2 is the default padding.
            yaxis: {
                pad: 1.05,
                tickOptions: {formatString: '%d'}
            }
        }
    });
}); </script>
    </body>
</html>
