<main>
    <div class="titles">Groups</div>
    <?php
    if ($groupA["code"] == true) {
        $dataA = $groupA["data"];
        for ($i = 0; $i < sizeof($dataA); $i++) {
            $cowA[] = $dataA[$i]["cowid"];
            $avgA[] = $dataA[$i]["average"];
        }
        $sizeA = sizeof($dataA);
    } else {
        $sizeA = 0;
    }

    if ($groupB["code"] == true) {
        $dataB = $groupB["data"];
        for ($i = 0; $i < sizeof($dataB); $i++) {
            $cowB[] = $dataB[$i]["cowid"];
            $avgB[] = $dataB[$i]["average"];
        }
        $sizeB = sizeof($dataB);
    } else {
        $sizeB = 0;
    }

    if ($groupC["code"] == true) {
        $dataC = $groupC["data"];
        for ($i = 0; $i < sizeof($dataC); $i++) {
            $cowC[] = $dataC[$i]["cowid"];
            $avgC[] = $dataC[$i]["average"];
        }
        $sizeC = sizeof($dataC);
    } else {
        $sizeC = 0;
    }
    ?>
    <div class="subtitles groupA">Group A (10 to 25 Liters)</div>
    <div class="group cardA">
    
        <div class="cowList">
            <ul>
            <h2>Cows' List</h2>
            <?php
                    if ($sizeA == 0)
                    {
                        ?> <h2 class="empty">No cows here!</h2> <?php
                    }
                    else
                    {
                        for ($i = 0; $i < $sizeA; $i++) {
                            ?>
                            <li onclick="redirectToProfile('<?php echo $cowA[$i]; ?>');"> <?php echo ($i+1) . ". " . $cowA[$i] ?> </li>
                            <?php
                        }
                    }
                
            ?>
            </ul>
        </div>
        <div class="graph">
            <canvas id="groupAChart"></canvas>
        </div>
    </div>

    <script>
        var labels = <?php echo json_encode($cowA); ?>;
        var chartData = <?php echo json_encode($avgA); ?>;
        var ctx = document.getElementById('groupAChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average (Liters)',
                    data: chartData,
                    backgroundColor: '#EF5350',
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }

            }
        });

    </script>

    <div class="subtitles groupB">Group B (25 to 35 Liters)</div>
    <div class="group cardB">
        
       
        <div class="cowList">
            <ul>
            <h2>Cows' List</h2>
            <?php
                    if ($sizeB == 0)
                    {
                        ?> <h2 class="empty">No cows here!</h2> <?php
                    }
                    else
                    {
                        for ($i = 0; $i < $sizeB; $i++) {
                            ?>
                            <li onclick="redirectToProfile('<?php echo $cowB[$i]; ?>');"> <?php echo ($i+1) . ". " . $cowB[$i] ?> </li>
                            <?php
                        }
                    }
                
            ?>
            </ul>
        </div>
        <div class="graph">
            <canvas id="groupBChart"></canvas>
        </div>
    </div>

    <script>
        var labels = <?php echo json_encode($cowB); ?>;
        var chartData = <?php echo json_encode($avgB); ?>;
        var ctx = document.getElementById('groupBChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average (Liters)',
                    data: chartData,
                    backgroundColor: '#42A5F5',
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }

            }
        });

    </script>

    <div class="subtitles groupC">Group C (35 to 45 Liters)</div>
    <div class="group cardC">
        
        <div class="cowList">
            <ul>
            <h2>Cows' List</h2>
                <?php
                    if ($sizeC == 0)
                    {
                        ?> <h2 class="empty">No cows here!</h2> <?php
                    }
                    else
                    {
                        for ($i = 0; $i < $sizeC; $i++) {
                            ?>
                            <li onclick="redirectToProfile('<?php echo $cowC[$i]; ?>');"> <?php echo ($i+1) . ". " . $cowC[$i] ?> </li>
                            <?php
                        }
                    }
                
                ?>
            </ul>
        </div>
        <div class="graph">
            <canvas id="groupCChart"></canvas>
        </div>
    </div>

    <script>
        var labels = <?php echo json_encode($cowC); ?>;
        var chartData = <?php echo json_encode($avgC); ?>;
        var ctx = document.getElementById('groupCChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average (Liters)',
                    data: chartData,
                    backgroundColor: '#E64A19',
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }

            }
        });

    </script>

</main>