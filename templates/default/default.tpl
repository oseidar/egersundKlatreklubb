<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>[@title]</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="resources/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="resources/js/ajax.js"></script>
        <script type="text/javascript" src="resources/js/script.js"></script>
        [@moduleScript]
        <link type="text/css" rel="stylesheet" href="templates/default/default.css"/>
        [@moduleCss]
    </head>
    <body>
        <div id="mainWrapper">
            <div id="mainContainer">
                <div id="logoWrapper">Egersund klatre og tindeklubb</div>
                <div id="menuWrapper">
                    <div id="mainMenu">
                        [@menu]
                    </div>
                </div>
                <div id="mainContentContainer">
                    <div id="slideshowWrapper">
                        <img src="../../public/images/slide2.jpg" alt=""/>
                    </div>
                    <div id="contentWrapper">
                        [@content]
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>