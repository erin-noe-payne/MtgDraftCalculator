
<body>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/index.js"></script>

    <div id="container">
        <div class="title">
            <h1>QuickMTG</h1>
            <h2>Draft Calculator</h2>
        </div>
        <div class="content">
            <form id="draftForm" action="<?= base_url() ?>index.php/Mtgdc/newDraft" method="post">

                <input class="numberField" name="bestOf" type="hidden" value="3"/>

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
        <div class="footer">
            <p><a target="_blank" href="http://www.quickmtg.com/">quickmtg.com</a></p>
        </div>
    </div>

    <div class="modal <?= ($previousSession ? '' : 'hidden') ?>">
        <div class="modalContent">
            <h4>Welcome back!</h4>
            <p>It appears that you have a draft that is still active.
                Please select whether you would like to return to your saved draft, or start a new one.</p>
            <br/>
            <br/>
            <div>
                <a href="<?= base_url() ?>index.php/Mtgdc/round"><button>Return to saved draft</button></a>
                <button id="closeModal" class="alignRight">Start a new draft</button>
            </div>
        </div>
    </div>
</body>

