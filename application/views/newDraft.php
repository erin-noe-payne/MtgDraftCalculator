<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<body>

    <div id="container">
        <div class="title">
            <h2>Seating</h2>
        </div>
        <div class="shadow"></div>
        <div class="content">
            <div class="contentSection">
                <div class="contentLeft">
                    <h4>Order</h4>
                    <p>Players will sit around a table in the order displayed.
                </div>
                <div class="contentRight">
                    <ol>
                        <?php
                        $players = array('Erin', 'Chris', 'Sean');
                        
                        foreach ($players as $name) {
                            printf('<li>%s</li>', $name);
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
    </div>
</body>

