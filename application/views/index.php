
<body>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/index.js"></script>

    <div id="container">
        <div class="title">
            <h1>QuickMTG</h1>
            <h2>Draft Calculator</h2>
        </div>
        <div class="content">
            <form id="draftForm" action="<?= base_url() ?>index.php/Mtgdc/newDraft" method="post">

                <div class="contentSection">
                    <div class="contentLeft">
                        <h4>Best of</h4>
                        <p>The number of games to be played in each match.</p>
                    </div>
                    <div class="contentRight">
                        <input class="numberField" name="bestOf" type="text" value="3"/>
                    </div>
                </div>

                <div class="contentSection">
                    <div class="contentLeft">
                        <h4>Players</h4>
                        <p>List the names of players participating in the draft.</p>
                    </div>
                    <div class="contentRight">
                        <ol id="nameList">
                            <li><input type="text" class="last"/></li>
                        </ol>
                    </div>
                </div>
                <input id="field_players" type="hidden" name="players"/>
                <div class="buttonBar">
                    <input type="submit" value="Start Draft!"/>
                </div>
            </form>
        </div>
    </div>
</body>

