<?php
//Random background image selector
try {
    $extList = array();
    $extList['gif'] = 'image/gif';
    $extList['jpg'] = 'image/jpeg';
    $extList['jpeg'] = 'image/jpeg';
    $extList['png'] = 'image/png';

    $folder = ($_SERVER['DOCUMENT_ROOT']) . 'resources/img/Backgrounds/';
    $fileList = array();
    $handle = opendir($folder);
    while (false !== ( $file = readdir($handle) )) {
        $file_info = pathinfo($file);
        if (isset($extList[strtolower($file_info['extension'])])) {
            $fileList[] = $file;
        }
    }
    closedir($handle);

    if (count($fileList) > 0) {
        $imageNumber = time() % count($fileList);
        $img = $fileList[$imageNumber];
    }
} catch (Exception $e) {
    $img = 'BurningRage.png';
}
?>

<body style="background-image: url(<?= base_url() ?>resources/img/Backgrounds/<?= $img ?>);">
    <script>
        //PHP -> JS data dump
        var BESTOF=<?= $draft->bestOfGames ?>;
        var PLAYERS=<?= json_encode($draft->players) ?>;
    </script>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/round.js"></script>

    <div id="help" class="modal hidden">
        <div class="modalContent">
            <img class="buttonForm" src="<?= base_url() ?>resources/img/roundHelp.png"/>
            <br/><h4>Use the score card to fill out match results.  </h4>
            <p>The number fields, from left to right, represent player 1 wins, draws, and player 2 wins. In the example shown here:
            <ul>
                <li>Caitlin has beat Sean 2-0</li>
                <li>Justin beat Natasha in the first game, and the second ended in a draw</li>
                <li>Lindsay beat Erin 2-1, and Erin has chosen to drop from the tournament (he will not be placed in following rounds).</li>
                <li>Chris was given a bye</li>
            </ul>
        </div>
    </div>

    <div class="modal <?= ($canPlayNextRound ? 'hidden' : '') ?>">
        <div class="modalContent">
            <h4>Uh oh!</h4>
            <p>It looks like there are no more legal pairings left. We have to end the draft. 
                Click the button below to continue to the final score sheet.</p>
            <br/>
            <br/>
            <div>
                <a href="<?= base_url() ?>index.php/Mtgdc/scoreSheet"><button>End Draft</button></a>

            </div>
        </div>
    </div>

    <div id="container">
        <div class="title">
            <h1>Round</h1>
            <h2>
                <?php
                $number_to_text = array('Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten');
                if ($draft->roundNumber <= 10)
                    echo $number_to_text[$draft->roundNumber];
                else {
                    echo $draft->roundNumber;
                }
                ?>
            </h2>
        </div>
        <div class="content">
            <div title="Help" class="helpButtonContainer"><div class="helpButton ui-icon-help ui-icon"></div></div>
            <div class="contentSection">
                <h4> Pairings </h4>
                <p>Play out matches according to the following pairings. Enter results before moving on to the next round or ending the draft.</p>
                <br/>
                <br/>
                <table>
                    <tr>
                        <th><p class="alignRight">Drop</p></th>
                    <th></th>
                    <th class="borderTop borderRight"><p>Wins</p></th>
                    <th><p>Draw</p></th>
                    <th class="borderTop borderLeft"><p>Wins</p></th>
                    <th></th><th><p>Drop</p></th>
                    </tr>
                    <?php
                    $players = $draft->players;
                    for ($i = 0; $i < count($players); $i++) {
                        $opponent1 = $players[$i]->name;
                        $class = ($i % 4 == 0) ? 'trLight' : 'trDark';

                        $scores = array('', '', '', '');
                        $opp1Drop = '';
                        $opp2Drop = '';
                        if ($draft->scoresForThisRound != null) {
                            $scores = $draft->scoresForThisRound[$players[$i]->id];
                            $opp1Drop = $scores[3] == true ? 'checked="checked"' : '';
                        }


                        if (++$i < count($players)) {
                            $opponent2 = $players[$i]->name;
                            if ($draft->scoresForThisRound != null) {
                                $opp2Drop = $draft->scoresForThisRound[$players[$i]->id][3] == true ? 'checked="checked"' : 'true';
                            }
                            printf(
                                    '<tr class="dataRow %s">
                                <td><input type="checkbox" %s/></td>
                                <td><p class="alignRight">%s</p></td>
                                <td class="borderRight"><input class="numberField" value="%s"/></td>
                                <td><input class="numberField" value="%s"/></td>
                                <td class="borderLeft"><input class="numberField"  value="%s"/></td>
                                <td><p class="alignLeft">%s</p></td>
                                <td><input type="checkbox" %s/></td>
                                </tr>', $class, $opp1Drop, $opponent1, $scores[0], $scores[1], $scores[2], $opponent2, $opp2Drop
                            );
                        } else {
                            $wins = 2;
                            printf(
                                    '<tr class="dataRow %s">
                                <td><input type="checkbox" %s/></td>
                                <td><p class="alignRight">%s</p></td>
                                <td class="borderRight"><input class="numberField" value="%d" disabled="disabled"/></td>
                                <td><input class="numberField" disabled="disabled" value="%s"/></td>
                                <td class="borderLeft"><input class="numberField" disabled="disabled" value="%s"/></td>
                                <td><p class="alignLeft">%s</p></div></div></td>
                                <td></td>
                                </tr>', $class, $opp1Drop, $opponent1, $wins, $scores[1], $scores[2], 'BYE'
                            );
                        }
                    }
                    ?>
                </table>
            </div>

            <div class="buttonBar">
                <form class="buttonForm" action="<?= base_url() ?>index.php/Mtgdc/round" method="post">
                    <input name="scores" type="hidden"/>
                    <input name="round" type="hidden" value="<?= $draft->roundNumber + 1 ?>"/>
                    <input type="submit" value="Go to Round <?= $draft->roundNumber + 1 ?>"/>
                </form>
                <?php
                if ($draft->roundNumber > 1) {
                    echo '<form class="backButtonForm" action="' . base_url() . 'index.php/Mtgdc/round" method="post">
                        <input name="round" type="hidden" value="' . ($draft->roundNumber - 1) . '"/>
                        <input type="submit" value="Go Back"/>
                        </form>';
                }
                ?>
                <form class="alignRight" action="<?= base_url() ?>index.php/Mtgdc/scoreSheet" method="post">
                    <input name="scores" type="hidden"/>
                    <input name="round" type="hidden" value="<?= $draft->roundNumber + 1 ?>"/>
                    <input type="submit" value="End Draft"/>
                </form>
            </div>
        </div>