<body>

    <div id="container">
        <div class="title">
            <h1>Round</h1><h2><?= 'One' ?></h2>
        </div>
        <div class="shadow"></div>
        <div class="content">
            <div class="contentSection">
                <h4> Pairings </h4>
                <p>Play out matches according to the following pairings. Enter results before moving on to the next round.</p>
                <br/>
                <table>
                    <tr>
                        <th><p>Opponent 1</p></th><th><p>W</p></th><th><p>D</p></th><th><p>W</p></th><th><p>Opponent 2</p></th>
                    </tr>
                    <tr>
                        <td><p>Erin</p></td>
                        <td><input class="numberField"/></td>
                        <td><input class="numberField"/></td>
                        <td><input class="numberField"/></td>
                        <td><p>Chris</p></td>
                    </tr>
                </table>
            </div>

            <div class="buttonBar">
                <a href="<?= base_url() ?>index.php/Mtgdc/round"><button>Go to Round <?= 2 ?></button></a>
                <a href="<?= base_url() ?>index.php/Mtgdc/scoreSheet"><button>End Draft</button></a>
            </div>
        </div>
    </div>
</body>