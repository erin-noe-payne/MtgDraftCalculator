
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
                <p>Congratulations on another successful draft. If you are running low on supplies, 
                    make sure to check out <a target="_blank" href="http://www.quickmtg.com/">quickmtg.com</a>, 
                    where you can get the cheapest booster boxes on the internet!</p>
                <br/>
                <br/>
                <table>
                    <tr>
                        <th><p>Rank</p></th>
                        <th class="borderRight"><p>Name</p></th>
                        <th><p>Wins</p></th>
                        <th><p>Draws</p></th>
                        <th class="borderRight"><p>Losses</p></th>
                        <th><p>Points</p></th>
                        <th><p>Byes</p></th>
                        <th><p>Drop?</p></th>
                    </tr>
                    <?php
                    $players = $draft->players;
                    $i=1;
                    foreach($players as $player) {
                        $class = ($i % 2 == 1) ? 'trLight' : 'trDark';

                        printf(
                                '<tr class="dataRow %s">
                                <td><p>%s</p></td>
                                <td class="borderRight alignLeft"><p>%s</p></td>
                                <td><p>%s</p></td>
                                <td><p>%s</p></td>
                                <td class="borderRight"><p>%s</p></td>
                                <td><p>%s</p></td>
                                <td><p>%s</p></td>
                                <td><p>%s</p></td>
                                </tr>', $class, $i, $player->name, $player->wins, 
                                $player->draws, $player->losses, $player->matchPoints, 
                                $player->byeCount, $player->dropped
                                
                        );
                        $i++;
                    }
                    ?>
                </table>
            </div>

            <div class="buttonBar">
                <a href="<?= base_url() ?>"><button>Save Results</button></a>
                <a class="alignRight" href="<?= base_url() ?>"><button>Start a new Draft</button></a>
            </div>
        </div>
        <div class="footer">
            <p><a target="_blank" href="http://www.quickmtg.com/">quickmtg.com</a></p>
        </div>
    </div>
</body>

