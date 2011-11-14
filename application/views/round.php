<body>
    <script type="text/javacript">BESTOF=<?=$draft->bestOfGames?></script>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/round.js"></script>

    <div id="container">
        <div class="title">
            <h1>Round</h1><h2><?= 'One' ?></h2>
        </div>
        <div class="content">
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
                                <td></td>
                                <td></td>
                                <td><p>%s</p><div title="Drop player" class="deleteButtonContainer alignRight"></div></div></td>
                                </tr>', $opponent1, $wins, 'BYE'
                            );
                        }
                    }
                    ?>
                </table>
            </div>

            <div class="buttonBar">
                <form action="<?= base_url() ?>index.php/Mtgdc/round" method="post">
                    <input name="scores" type="hidden"/>
                    <input type="submit" value="Go to Round <?= 2 ?>"/>
                </form>
                <form action="<?= base_url() ?>index.php/Mtgdc/scoreSheet" method="post">
                    <input name="scores" type="hidden"/>
                    <input type="submit" value="End Draft"/>
                </form>
            </div>
        </div>
    </div>
</body>