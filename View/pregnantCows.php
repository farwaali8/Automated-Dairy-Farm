<main>
    <h2 class="titles">Pregnant Cows</h2>
    <div class="category">
        <?php
        for ($i = 0; $i < sizeof($pregnantCows); $i++) {
            ?>
            <div class="animal pregnant" onclick="redirectToProfile('<?php echo $pregnantCows[$i]->cowid; ?>');">
                <div>
                    <div class="cowid">#<?= $pregnantCows[$i]->cowid ?></div>
                    <div class="startdate">From: <?php if ($pregnantCows[$i]->startdate == "0001-01-01") echo 'N/A';
                    else echo $pregnantCows[$i]->startdate; ?></div>
                </div>

                <div class="iconBx">
                    <img src=<?php echo $dots . './components/icons/kid.png' ?> alt="">
                </div>
            </div>
            <?php
        }
        ?>

    </div>

    

</main>