<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="<?= base_url() ?>resources/js/jQuery.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>resources/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>resources/js/index.js"></script>
        <link rel="stylesheet" href="<?= base_url() ?>resources/css/mtgdc.css"/>
        <link rel="stylesheet" href="<?= base_url() ?>resources/css/overcast/jquery-ui.css"/>

    </head>
    <body>

        <div id="container">
            <div class="title">
                <h1>QuickMTG Presents:</h1>
                <h2>The MTG Draft Calculator</h2>
            </div>
            <div class="shadow"></div>
            <div class="content">
                <form id="draftForm" action="<?= base_url() ?>index.php/Mtgdc/newDraft" method="post">
                    Rounds are best of:
                    <input id="field_bestOf" name="bestOf" type="text" value="3"/>
                    <br/>
                    <br/>
                    Enter the names of the draft participants:
                    <ol id="nameList">
                        <li><input type="text" class="last"/></li>
                    </ol>
                    <input id="field_players" type="hidden" name="players"/>
                    <input type="submit" value="Start Draft!"/>
                </form>
            </div>
        </div>
    </body>
</html>
