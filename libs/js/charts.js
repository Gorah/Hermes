 $(document).ready(function(){
//       rounded corners in left-hand side menu
       $("#menu").corner();
//     Ajax call to generate datasets for charts and feed them into charts  
       $.ajax({
            type: 'GET',
                url: "../php/chartDataFeed.php",
                success: function(data){
//                 Bartool Open/Closed Cases - daily Breakdown   
                   drawVolumesBartool(data);
                   drawTATBartool(data);
                   drawFNABartool(data);
                }
       });
       
       
       
       function drawVolumesBartool(seriesData){
//     parsing JSON received from AJAX call  
       var arrOb = $.parseJSON(seriesData);
//     exploding volumes string into an array in order to have jqplot parse it as
//     a data series of first serie
       var s1 = arrOb.volumes.split(",");
//     serie 2 array creation, array will be filled with data about closed cases
       var s2 = [];
//     temporary array for script comparison purposes  
       var tempArr = arrOb.dailyClosed[0];
       
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
        var ticks = arrOb.dates.split(",");
        ticks[9] = ticks[9]+"'";
        
//      Loop matching dates from ticks with dates in cases closed array labels
//      If there's a date match, array is appended with volume. If there's no match
//      array is appended with 0. This is to compensate SQL query issue with nulls
        $.each(ticks, function(){
            if(this in tempArr) {
                s2.push(tempArr[this]);
            } else {
                s2.push(0);
            }
        });
     
    var plot1 = $.jqplot('chart1', [s1, s2], {
        // The "seriesDefaults" option is an options object that will
        // be applied to all series in the chart.
        title: 'Opened/Closed Cases - daily breakdown',
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true},
            pointLabels: { show: true, location: 'n', edgeTolerance: -15 }
        },
        // Custom labels for the series are specified with the "label"
        // option on the series option.  Here a series option object
        // is specified for each series.
        series:[
            {label:'Opened Cases', color:'#00FF7F'},
            {label: 'Cases Closed', color: '#FF2400'}
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
                tickOptions: {formatString: '%d'},
                max: 150
            }
        }
    });
    
    
       }    

       function drawTATBartool(seriesData){
//     parsing JSON received from AJAX call  
       var arrOb = $.parseJSON(seriesData);
//     exploding volumes string into an array in order to have jqplot parse it as
//     a data series of first serie
       var s1 = [];
//     serie 2 array creation, array will be filled with data about closed cases
//     temporary array for script comparison purposes  
       var tempArr = arrOb.TATdet[0];
       
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
        var ticks = arrOb.TATdates.split(",");
        ticks[9] = ticks[9]+"'";
        
//      Loop matching dates from ticks with dates in cases closed array labels
//      If there's a date match, array is appended with volume. If there's no match
//      array is appended with 0. This is to compensate SQL query issue with nulls
        $.each(ticks, function(){
            if(this in tempArr) {
                s1.push(tempArr[this]);
            } else {
                s1.push(0);
            }
        });
     
    var plot2 = $.jqplot('afterTATVol', [s1], {
        // The "seriesDefaults" option is an options object that will
        // be applied to all series in the chart.
        title: 'After TAT Cases - daily breakdown',
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true},
            pointLabels: { show: true, location: 'n', edgeTolerance: -15 }
        },
        // Custom labels for the series are specified with the "label"
        // option on the series option.  Here a series option object
        // is specified for each series.
        series:[
            {label: 'Late Cases', color: '#FF2400'}
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
       }
       
        function drawFNABartool(seriesData){
//     parsing JSON received from AJAX call  
       var arrOb = $.parseJSON(seriesData);
//     exploding volumes string into an array in order to have jqplot parse it as
//     a data series of first serie
       var s1 = arrOb.fnaVols.split(",");
       if(s1 == "") {s1 =[0,0,0,0,0,0,0,0,0,0]}
//     serie 2 array creation, array will be filled with data about closed cases
//     temporary array for script comparison purposes  
       
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
        var ticks = arrOb.fnaDates.split(",");
        ticks[9] = ticks[9]+"'";
        
        if(ticks[0] == "") { ticks = ["","","","","","","","","",""]}
        
    var plot3 = $.jqplot('fnaVol', [s1], {
        // The "seriesDefaults" option is an options object that will
        // be applied to all series in the chart.
        title: 'F&A Cases - daily breakdown',
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true},
            pointLabels: { show: true, location: 'n', edgeTolerance: -15 }
        },
        // Custom labels for the series are specified with the "label"
        // option on the series option.  Here a series option object
        // is specified for each series.
        series:[
            {label: 'F&A Cases', color: '#FF2400'}
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
       }
});

   