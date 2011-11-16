
<body>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/index.js"></script>

    <div id="container">
        <div class="title">
            <h2>Rankings</h2><h1>&nbsp;</h1>
        </div>
        <div class="content">
            <div title="Help" class="helpButtonContainer"><div class="helpButton ui-icon-help ui-icon"></div></div>
            <div class="contentSection">
                <h4> Final Scoring </h4>
                <p>Congratulations on another successful draft! If you are running low on supplies, 
                    make sure to check out <a href="http://www.quickmtg.com/">quickmtg.com</a>, 
                    where you can get the cheapest booster boxes on the internet. The rankings are listed below.</p>
                <br/>
                <br/>
                <table>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Wins</th>
                        <th>Draws</th>
                        <th>Losses</th>
                        <th>Points</th>
                        <th>Byes</th>
                        <th>Dropped?</th>
                        <th></th>
                    </tr>
                    <?php
                    $players = $draft->players;
                    for ($i = 1; $i <= count($players); $i++) {
                        $player = $players[$i]->name;
                        $class = ($i % 2 == 0) ? 'trLight' : 'trDark';

                        printf(
                                '<tr class="dataRow %s">
                                <td><input type="checkbox"/></td>
                                <td><p class="alignRight">%s</p></td>
                                <td class="borderRight"><input class="numberField"/></td>
                                <td><input class="numberField"/></td>
                                <td class="borderLeft"><input class="numberField"/></td>
                                <td><p class="alignLeft">%s</p></td>
                                <td><input type="checkbox"/></td>
                                </tr>', $class, $opponent1, $opponent2
                        );
                    }
                    ?>
                </table>
            </div>

            <div class="buttonBar">
                <form class="buttonForm" action="<?= base_url() ?>index.php/Mtgdc/round" method="post">
                    <input name="scores" type="hidden"/>
                    <input type="submit" value="Go to Round <?= $draft->roundNumber + 1 ?>"/>
                </form>
                <form action="<?= base_url() ?>index.php/Mtgdc/scoreSheet" method="post">
                    <input name="scores" type="hidden"/>
                    <input type="submit" value="End Draft"/>
                </form>
            </div>
        </div>
    </div>
</body>

