<body>

    <div id="container">
        <div class="title">
            <h2>Seating</h2><h1>&nbsp;</h1>
        </div>
        <div class="content">
            <div class="contentSection">
                <div class="contentLeft">
                    <h4>Order</h4>
                    <p>Players will sit around a table in the order displayed.</p>
                </div>
                <div class="contentRight">
                    <ol>
                        <?php
                        $players = $draft->players;

                        foreach ($players as $player) {
                            printf('<li>%s</li>', $player->name);
                        }
                        ?>
                    </ol>
                </div>
            </div>

            <div class="buttonBar">
                <form action="<?= base_url() ?>index.php/Mtgdc/round" method="get">
                    <input type="submit" value="Go to Round 1"></input>
                </form>
            </div>
        </div>
        <div class="footer">
            <p><a target="_blank" href="http://www.quickmtg.com/">quickmtg.com</a></p>
        </div>
    </div>
</body>

