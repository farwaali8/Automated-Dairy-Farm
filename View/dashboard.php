<main>
    <div class="topBar">
        <div class="pageTitle">Dashboard</div>
        <div class="search">
            <input id="what" type="search" placeholder="search anything">
            <button onclick="search()">Search</button>
        </div>
    </div>
    <div class="cardBox">
        <div class="card" onclick="window.location='pregnantCows';">
            <div>
                <div class="numbers pink"><?= sizeof($pregnantCows) ?></div>
                <div class="cardName">Pregnant Cows</div>
            </div>

            <div class="iconBx">
                <img src=<?php echo $dots . './components/icons/cow.png' ?> alt="">
            </div>
        </div>

        <div class="card" onclick="window.location='health#sickAnimals';">
            <div>
                <div class="numbers darkred"><?= $sickCount ?></div>
                <div class="cardName">Sick Animals</div>
            </div>

            <div class="iconBx">
                <img src=<?php echo $dots . './components/icons/temperature.png' ?> alt="">
            </div>
        </div>

        <div class="card" onclick="window.location='lowYieldCows';">
            <div>
                <div class="numbers warning"><?= $lowYieldCowsCount ?></div>
                <div class="cardName">Low-Yield Cows</div>
            </div>

            <div class="iconBx">
                <img src=<?php echo $dots . './components/icons/low.png' ?> alt="">
            </div>
        </div>
    </div>


    <div class="todayStats titles">Statistics</div>
    <div class="smallcardbox">

        <div class="smallcard milk">
            <div class="milkqnt"><?= $_SESSION['todayMilk'] ?> L</div>
            <div class="text">Milk Today</div>
        </div>

        <div class="smallcard price">
            <div class="milkqnt"><?= $_SESSION['todayProfit'] ?> Rs</div>
            <div class="text">Sale Price</div>
        </div>

        <div class="smallcard expense">
            <div class="milkqnt"><?= $_SESSION['todayExpense'] ?> Rs</div>
            <div class="text">Expense Today</div>
        </div>

        <div class="smallcard profit">
            <div class="milkqnt"><?= $_SESSION['todayProfit'] - $_SESSION['todayExpense'] ?> Rs</div>
            <div class="text">Profit Today</div>
        </div>
    </div>

    <div class="outerContainer">
        <div class="chart-container">
            <canvas id="weekBarChart"></canvas>
            <span class="text-muted"><i>Last Seven Days' Record</i></span>
        </div>
    </div>

    <script>
        function search() {
            var what = $("#what").val();
            if (!what)
            {
                showToast("Search something!", "invalid");
                return;
            }
            window.location.href = './search?what=' + what;
        }

        var labels = <?php echo json_encode($labels); ?>;
        var chartData = <?php echo json_encode($chartData); ?>;
        var expenseReport = <?php echo json_encode($expenseReport); ?>;
        var profit = <?php echo json_encode($profit); ?>;

        var ctx = document.getElementById('weekBarChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Milk (Liters)',
                    data: chartData,
                    backgroundColor: 'blue',
                    barThickness: 20,
                }, {
                    label: 'Expenses (Rs)',
                    data: expenseReport,
                    backgroundColor: 'red',
                    barThickness: 20,
                }, {
                    label: 'Profit (Rs)',
                    type: 'line',
                    data: profit,
                    backgroundColor: 'green',
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

    <div class="groupsDash">
        <div>
            <canvas id="groupsPieChart"></canvas>
        </div>
        <div>
            <canvas id="breedsChart"></canvas>
        </div>
    </div>

    <script>
        var labels = ['Group A', 'Group B', 'Group C'];
        var chartData = <?php echo json_encode($counts); ?>;
        var backgroundColors = ['#EF5350', '#42A5F5', '#E64A19'];
        var ctx = document.getElementById('groupsPieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cows',
                    data: chartData,
                    backgroundColor: backgroundColors,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Groups' Frequency",
                        font: {
                            size: 16,
                            weight: 'bold',
                            family: 'Arial, sans-serif'
                        }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });


        var labels = <?php echo json_encode($breeds); ?>;
        var chartData = <?php echo json_encode($Counts); ?>;
        var backgroundColors = generateRandomColors(labels.length);
        var ctx = document.getElementById('breedsChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cattles',
                    data: chartData,
                    backgroundColor: backgroundColors,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Breeds' Frequency",
                        font: {
                            size: 16,
                            weight: 'bold',
                            family: 'Arial, sans-serif'
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                cutout: 80
            }
        });
        function generateRandomColors(count) {
            var colors = [];
            for (var i = 0; i < count; i++) {
                var color = '#' + Math.floor(Math.random() * 16777215).toString(16);
                colors.push(color);
            }
            return colors;
        }


    </script>

</main>