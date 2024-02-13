<main>
    <?php
    if ($lowYieldCows["code"] == true) {
        $data = $lowYieldCows["data"];
        for ($i = 0; $i < sizeof($data); $i++) {
            $cow[] = $data[$i]["cowid"];
            $avg[] = $data[$i]["average"];
        }
        $size = sizeof($data);
    } else {
        $size = 0;
    }
    ?>


    <h2 class="titles">Low-Yield Cows</h2>
    
    <p class="intro">These cows have produced average milk below 10 liters in past seven days</p>
    <div class="category">
        <?php
        for ($i = 0; $i < $size; $i++) {
            ?>
            <div class="animal low" onclick="redirectToProfile('<?php echo $cow[$i]; ?>');">
                <div>
                    <div class="cowid">#<?= $cow[$i] ?></div>
                    <div class="startdate">Average : <?= number_format($avg[$i], 2); ?> </div>
                </div>

                <div class="iconBx">
                    <img src=<?php echo $dots . './components/icons/thumb-down.png' ?> alt="img">
                </div>
            </div>
            <?php
        }
        ?>

    </div>



</main>