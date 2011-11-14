<?php
//Random background image selector
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
?>

<body style="background-image: url(<?= base_url() ?>resources/img/Backgrounds/<?= $img ?>);">
    <script>
        //PHP data dump
        var BESTOF=<?= $draft->bestOfGames ?>;
        var PLAYERS=<?= json_encode($draft->players) ?>;
    </script>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/round.js"></script>

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
                <p>Play out matches according to the following pairings. Enter results before moving on to the next round.</p>
                <br/><p>W = Win</p>
                <br/><p>D = Draw</p>
                <br/>
                <br/>
                <table>
                    <tr>
                        <th><p class="alignRight">Opponent 1</p></th><th><p>W</p></th><th><p>D</p></th><th><p>W</p></th><th><p>Opponent 2</p></th>
                    </tr>
                    <?php
                    $players = $draft->players;
                    for ($i = 0; $i < count($players); $i++) {
                        $opponent1 = $players[$i]->name;
                        if (++$i < count($players)) {
                            $opponent2 = $players[$i]->name;
                            printf(
                                    '<tr class="dataRow">
                                <td><div title="Drop player" class="deleteButtonContainer"><div class="deleteButton ui-icon-close ui-icon"></div></div><p class="alignRight">%s</p></td>
                                <td><input class="numberField"/></td>
                                <td><input class="numberField"/></td>
                                <td><input class="numberField"/></td>
                                <td><p>%s</p><div title="Drop player" class="deleteButtonContainer alignRight"><div class="deleteButton ui-icon-close ui-icon"></div></div></td>
                                </tr>', $opponent1, $opponent2
                            );
                        } else {
                            $wins = 2;
                            printf(
                                    '<tr class="dataRow">
                                <td><div title="Drop player" class="deleteButtonContainer"><div class="deleteButton ui-icon-close ui-icon"></div></div><p class="alignRight">%s</p></td>
                                <td><input class="numberField" value="%d" disabled="disabled"/></td>
                                <td><input class="numberField" disabled="disabled"/></td>
                                <td><input class="numberField" disabled="disabled"/></td>
                                <td><p>%s</p></div></div></td>
                                </tr>', $opponent1, $wins, 'BYE'
                            );
                        }
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

    <div id="help">
        <div id="helpContainer">
            <img class="buttonForm" src="<?= base_url() ?>resources/img/roundHelp.png"/>
            <br/><h4>Use the score card to fill out match results.  </h4>
            <p>The number fields, from left to right, represent player 1 wins, draws, and player 2 wins. In the example shown here:
            <ul>
                <li>Erin has beat Sean 2-0</li>
                <li>Natasha beat Lindsay in the first game, and the second ended in a draw</li>
                <li>Caitlin beat Justin 2-1</li>
                <li>Chris was given a bye</li>
            </ul>
        </div>
    </div>
</body>