
<body>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/scoreSheet.js"></script>

    <div id="help" class="modal hidden">
        <div class="modalContent">
            <h4>Ranking and Tiebreakers</h4>
            <p>Your final ranking is determined by the following tiebreakers (in order):</p>
            <ol>
                <li><b>MP</b> - Match Points. Wins are worth 3 points, draws worth 1, and losses 0.</li>
                <li><b>OMW</b> - Opponent Match Win Percentage. The average match win percentage of each opponent that a player faced. </li>
                <li><b>GW</b> - Game Win Percentage. The player's win percentage over all games played.</li>
                <li><b>OGW</b> - Opponent Game WIn Percentage. The average game win percentage of each opponent that a player faced.</li>
            </ol>
            <p>Note: For all game and match win percentages, byes are ignored. The minimum possible value for any match or game win percentage is 0.33.</p>
            <br/>
            <p>For the complete rules on scoring and tiebreakers as used by the quickmtg draft calculator, refer to the 
                "<a href="http://www.wizards.com/wpn/Document.aspx?x=Magic_The_Gathering_Tournament_Rules" target="_blank">Magic: The Gathering Tournament Rules.</a>"</p>

        </div>
    </div>

    <div id="container">
        <div class="title">
            <h2>Rankings</h2><h1>&nbsp;</h1>
        </div>
        <div class="content">
            <div title="Help" class="helpButtonContainer"><div class="helpButton ui-icon-help ui-icon"></div></div>
            <div class="contentSection">
                <div class="contentSection">
                    <h4> Final Scoring </h4>
                    <p>Congratulations on another successful draft. If you are running low on supplies, 
                        make sure to check out <a target="_blank" href="http://www.quickmtg.com/">quickmtg.com</a>, 
                        where you can get the cheapest booster boxes on the internet!</p>
                </div>
                <div class="contentSection alighnCenter">
                    <div class="tableContainer">
                        <table id="scoreSheet">
                            <tr>
                                <th><p>Rank</p></th>
                            <th class="borderRight"><p>Name</p></th>
                            <th><p>Wins</p></th>
                            <th><p>Losses</p></th>
                            <th class="borderRight"><p>Draws</p></th>
                            <th class="" title="Match Points"><p>MP</p></th>
                            <th class="" title="Opponent Match Win %"><p>OMW</p></th>
                            <th class="" title="Game Win %"><p>GW</p></th>
                            <th class="" title="Opponent Match Win %"><p>OGW</p></th>
                            </tr>
                            <?php
                            $players = $draft->players;
                            $i = 1;
                            foreach ($players as $player) {
                                $class = ($i % 2 == 1) ? 'trLight' : 'trDark';

                                printf(
                                        '<tr class="dataRow %s">
                                <td><p>%s</p></td>
                                <td class="borderRight alignLeft"><p>%s</p></td>
                                <td><p>%s</p></td>
                                <td><p>%s</p></td>
                                <td class="borderRight"><p>%s</p></td>
                                <td class=""><p>%s</p></td>
                                <td class=""><p>%.2f</p></td>
                                <td class=""><p>%.2f</p></td>
                                <td class=""><p>%.2f</p></td>
                                </tr>', $class, $i, $player->name, $player->mWins, $player->mLosses, $player->mDraws, $player->matchPoints, $player->opponentMatchWinPerc, $player->gameWinPerc, $player->opponentGameWinPerc
                                );
                                $i++;
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="buttonBar">
                <a class="alignRight" href="<?= base_url() ?>"><button>Start a new Draft</button></a>
            </div>
        </div>


