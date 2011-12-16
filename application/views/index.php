<body>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/index.js"></script>


    <div id="oldDraft" class="modal <?= ($previousSession ? '' : 'hidden') ?>">
        <div class="modalContent">
            <h4>Welcome back!</h4>
            <p>It appears that you have a draft that is still active.
                Please select whether you would like to return to your saved draft, or start a new one.</p>
            <br/>
            <br/>
            <div>
                <?php
                $redirectURL = base_url() . 'index.php/mtgdc/round';
                if ($previousSession && $draft->isDone) {
                    $redirectURL = base_url() . 'index.php/mtgdc/scoresheet';
                }
                ?>
                <a href="<?= $redirectURL ?>"><button>Return to saved draft</button></a>
                <button id="closeModal" class="alignRight">Start a new draft</button>
            </div>
        </div>
    </div>

    <div id="help" class="modal hidden">
        <div class="modalContent">
            <h4>Welcome to the QuickMTG Draft Calculator</h4>
            <p>Want to know how it all works? Here is a brief overview:</p>
            <ul>
                <li>The calculator can be used for any home tournament or draft.</li>
                <li>To get started, just begin typing in the names of everyone who is participating. There is a 12 player limit.</li>
                <li>Each round is a best of 3 games.</li>
                <li>Play as many rounds as you like.  When you are finished click the "End Draft" button to go to the final scores.
                    And if you make a mistake, you can always go back!</li>
                <li>If the draft calculator runs out of legal pairings, it will force you to end the draft. Sorry!</li>
                <li>All matchmaking, scoring, and selection of byes is done according to Wizards of the Coast's official 
                    "<a href="http://www.wizards.com/wpn/Document.aspx?x=Magic_The_Gathering_Tournament_Rules" target="_blank">Magic: The Gathering Tournament Rules.</a>"</li>
            </ul>
        </div>
    </div>

    <div id="container">
        <div class="title">
            <h1>QuickMTG</h1>
            <h2>Draft Calculator</h2>
        </div>
        <div class="content">
            <div title="Help" class="helpButtonContainer"><div class="helpButton ui-icon-help ui-icon"></div></div>
            <form id="draftForm" action="<?= base_url() ?>index.php/mtgdc/newDraft" method="post">

                <input class="numberField" name="bestOf" type="hidden" value="3"/>

                <div class="contentSection">
                    <div class="contentLeft">
                        <h4>Players</h4>
                        <p>List the names of players participating in the draft.</p>
                    </div>
                    <div class="contentRight">
                        <ol id="nameList">
                            <li><input type="text" class="last"></input></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden"><input type="text" class=""></li>
                            <li class="hidden final"><input type="text" class=""></li>
                        </ol>
                    </div>
                </div>
                <input id="field_players" type="hidden" name="players"/>
                <div class="buttonBar">
                    <input type="submit" value="Start Draft!"/>
                </div>
            </form>
        </div>


