<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="./libs/js/excanvas.min.js"></script><![endif]-->
        <script language="javascript" type="text/javascript" src="./libs/js/jquery-1.7.2.js"></script>
        <script language="javascript" type="text/javascript" src="./libs/js/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="./libs/js/plugins/jqplot.barRenderer.min.js"></script>
        <script type="text/javascript" src="./libs/js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="./libs/js/plugins/jqplot.pointLabels.min.js"></script>
        <script type="text/javascript" src="./libs/js/jquery.corner.js"></script>
        <link rel="stylesheet" type="text/css" href="./libs/css/jquery.jqplot.css" />
        <link rel="stylesheet" type="text/css" href="./libs/css/style.css" />
        <title>Hermes reporting tool</title>
    </head>
    <body>
        <div id="mainContainer">
            <div id="hermesLogo">
                <img src="./img/hermes.gif" id="hLogo"/>
            </div>
            <div id="loginForm">
                <form id="fLogin" action="./libs/php/auth.php" method="POST">
                    <h4 style="text-align: center;">Please login</h4>
                    <table style="margin-left: 20px; margin-bottom: 10px;">
                        <tbody>
                            <tr><th class="login">User Name:</th><td><input type="text" name="logon" size="20"/></td></tr>
                            <tr><th class="login">Password:</th><td><input type="password" name="pass" size="20"/></td></tr>
                            <tr><td colspan="2" align="center"><input type="submit" id="logSubmit" style="text-align: center;"/></td></tr>
                        </tbody>
                    </table>
                    <div id="submitButton"></div>
                </form>
            </div>
            <div id="HPLogo">
                <img src="./img/HPLogo.jpg" id="hpLogoImg"/>
            </div>
            <div id="title"><h1>Hermes reporting tool</h1></div>
        </div>
        <script src="./libs/js/loginscreen.js"></script>
    </body>
</html>
<?php

?>


