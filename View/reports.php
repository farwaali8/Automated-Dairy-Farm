<main>
    <div class="titles">Reports</div>

    <div class="reportLinks">
        <a id="d" href="#page1">Daily</a>
        <a id="w" href="#page2">Weekly</a>
        <a id="m" href="#page3">Monthly</a>
    </div>
    <!-- Daily reports -->



    <div id="page1" class="reportCards dailyReports">
        <div class="duration">Daily Reports</div>
        <?php
        if ($dailyMilkRecords['code'] == true) {
            $data = $dailyMilkRecords['data'];
            $size = sizeof($data);
        } else
            $size = 0;

        $currentPage1 = isset($_GET['page1']) ? $_GET['page1'] : 1; // Use separate variable for Table 1 pagination
        $itemsPerPage = 7;
        $totalItems = $size;
        $totalPages = ceil($totalItems / $itemsPerPage);

        $startIndex = ($currentPage1 - 1) * $itemsPerPage;
        $endIndex = $startIndex + $itemsPerPage - 1;
        if ($endIndex >= $totalItems) {
            $endIndex = $totalItems - 1;
        }
        ?>
        <div class="dailyMilkTable reportTable">
            <table>
                <thead>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Milk (L)</th>
                    <th>Expense</th>
                    <th>Profit</th>
                </thead>
                <tbody>
                    <?php
                    for ($i = $startIndex; $i <= $endIndex; $i++) {
                        ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $data[$i]["date"] ?></td>
                            <td><?= $data[$i]["amount"] ?></td>
                            <td><?= $data[$i]["expense"] ?></td>
                            <td><?= $data[$i]["saleprice"] - $data[$i]["expense"] ?></td>
                        </tr> <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php if ($currentPage1 > 1): ?>
                    <a href="?page1=<?php echo ($currentPage1 - 1); ?>">Previous</a>
                <?php endif; ?>

                <?php
                $maxLinks = 5; // Maximum number of pagination links to display
                $ellipsisStart = ($currentPage1 - floor($maxLinks / 2)) > 1;
                $ellipsisEnd = ($currentPage1 + floor($maxLinks / 2)) < $totalPages;
                $startPage = $currentPage1 - floor($maxLinks / 2);
                $endPage = $currentPage1 + floor($maxLinks / 2);

                if ($ellipsisStart) {
                    echo "<a href='?page1=1'>1</a> ... ";
                }

                for ($page = $startPage; $page <= $endPage; $page++) {
                    if ($page >= 1 && $page <= $totalPages) {
                        if ($page == $currentPage1) {
                            echo "<a class='active' href='?page1=$page'>$page</a>";
                        } else {
                            echo "<a href='?page1=$page'>$page</a>";
                        }
                    }
                }

                if ($ellipsisEnd) {
                    echo " ... <a href='?page1=$totalPages'>$totalPages</a>";
                }
                ?>

                <?php if ($currentPage1 < $totalPages): ?>
                    <a href="?page1=<?php echo ($currentPage1 + 1); ?>">Next</a>
                <?php endif; ?>
            </div>
            <script>
                const paginationLinks1 = document.querySelectorAll('.pagination a');
                paginationLinks1.forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        const href = link.getAttribute('href');
                        window.history.pushState({}, '', href);
                        loadPage(href);
                    });
                });
                function loadPage(url) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', url);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            const parser = new DOMParser();
                            const newDoc = parser.parseFromString(xhr.responseText, 'text/html');
                            const bodyContent = newDoc.querySelector('body').innerHTML;
                            document.body.innerHTML = bodyContent;
                        }
                    };
                    xhr.send();
                }
            </script>
        </div>

        <div class="titles">Daily Report Chart</div>
        <div class="dailyReportChart">
            <canvas id="dailyReportChart"></canvas>
        </div>

        <script>
            var labels = <?php echo json_encode($days); ?>;
            var chartData = <?php echo json_encode($milkAmount); ?>;
            var ctx = document.getElementById('dailyReportChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Milk (Liters)',
                        data: chartData,
                        borderColor: 'red',
                        backgroundColor: '#FFEBEE',
                        pointBackgroundColor: 'red',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: "Daily Milk Production",
                            font: {
                                size: 15,
                                style: 'italic',
                                weight: 'bold'
                            },
                            align: 'end'
                        },
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            display: true,
                            text: 'Days', // Add the text description for x-axis labels
                            title: {
                                display: true,
                                text: 'Days',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                callback: function (value, index, values) {
                                    return ''; // Hide the x-axis labels
                                }
                            },
                            grid: {
                                display: false, // Hide the x-axis grid lines
                            }
                        }
                    }
                }
            });
        </script>

        <div class="cowsReports">
            <div class="titles">Individual Cows Reports</div>

            <?php
            if ($cowRecords['code'] == true) {
                $data2 = $cowRecords['data'];
                $size2 = sizeof($data2);
            } else
                $size2 = 0;

            $currentPage2 = isset($_GET['page2']) ? $_GET['page2'] : 1; // Use separate variable for Table 2 pagination
            $itemsPerPage = 7;
            $totalItems = $size2;
            $totalPages = ceil($totalItems / $itemsPerPage);

            $startIndex = ($currentPage2 - 1) * $itemsPerPage;
            $endIndex = $startIndex + $itemsPerPage - 1;
            if ($endIndex >= $totalItems) {
                $endIndex = $totalItems - 1;
            }
            ?>

            <div class="filter">

                <label id="filterlabel" for="cowFilter">Filter by Cow ID:</label>
                <select id="cowFilter" name="cowFilter">
                    <option value="">All Cows</option>
                    <?php for ($i = 0; $i < sizeof($cows); $i++) {
                        ?>
                        <option value="<?= $cows[$i] ?>" <?= isset($_GET['cowFilter']) && $_GET['cowFilter'] == $cows[$i] ? 'selected' : '' ?>>
                            <?= $cows[$i] ?>
                        </option>
                    <?php } ?>
                </select>
                <button id="applyFilter">Apply</button>
            </div>


            <div class="dailyMilkTable reportTable">
                <table id="cowTable">
                    <thead>
                        <th>No.</th>
                        <th>Cow ID</th>
                        <th>Date</th>
                        <th>Milk (L)</th>
                        <th>Times</th>
                    </thead>
                    <tbody id="cowTablebody">
                        <?php
                        for ($i = $startIndex; $i <= $endIndex; $i++) {
                            ?>
                            <tr class="cow-record">
                                <td><?= $i + 1 ?></td>
                                <td><?= $data2[$i]["cowid"] ?></td>
                                <td><?= $data2[$i]["date"] ?></td>
                                <td><?= $data2[$i]["milkamount"] ?></td>
                                <td><?= $data2[$i]["times"] ?></td>
                            </tr> <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="pagination" id="pagination">
                    <?php if ($currentPage2 > 1): ?>
                        <a href="?page2=<?php echo ($currentPage2 - 1); ?>">Previous</a>
                    <?php endif; ?>

                    <?php
                    $ellipsisStart = ($currentPage2 - floor($maxLinks / 2)) > 1;
                    $ellipsisEnd = ($currentPage2 + floor($maxLinks / 2)) < $totalPages;
                    $startPage = $currentPage2 - floor($maxLinks / 2);
                    $endPage = $currentPage2 + floor($maxLinks / 2);

                    if ($ellipsisStart) {
                        echo "<a href='?page2=1'>1</a> ... ";
                    }

                    for ($page = $startPage; $page <= $endPage; $page++) {
                        if ($page >= 1 && $page <= $totalPages) {
                            if ($page == $currentPage2) {
                                echo "<a class='active' href='?page2=$page'>$page</a>";
                            } else {
                                echo "<a href='?page2=$page'>$page</a>";
                            }
                        }
                    }

                    if ($ellipsisEnd) {
                        echo " ... <a href='?page2=$totalPages'>$totalPages</a>";
                    }
                    ?>

                    <?php if ($currentPage2 < $totalPages): ?>
                        <a href="?page2=<?php echo ($currentPage2 + 1); ?>">Next</a>
                    <?php endif; ?>
                </div>
                <script>
                    const paginationLinks2 = document.querySelectorAll('.pagination:nth-of-type(2) a');
                    paginationLinks2.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            window.scrollTo({ top: 200, behavior: 'smooth' });
                            const href = link.getAttribute('href');
                            window.history.pushState({}, '', href);
                            loadPage(href);
                        });
                    });
                    function loadPage(url) {
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', url);
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                const parser = new DOMParser();
                                const newDoc = parser.parseFromString(xhr.responseText, 'text/html');
                                const bodyContent = newDoc.querySelector('body').innerHTML;
                                document.body.innerHTML = bodyContent;
                            }
                        };
                        xhr.send();
                    }

                    function Filter_records(event) {

                        var id = $("#cowFilter").val();
                        if (!id) {
                            console.log("noooooooo");
                            return;
                        }


                        var formdata = new FormData();
                        formdata.append("cowid", id);



                        $.ajax({
                            url: './fetchReports?cowid=' + id,
                            contentType: false,
                            processData: false,
                            //data: formdata,
                            type: "GET",
                            success: (message) => {
                                var response = JSON.parse(message);
                                var data = response.data;
                                var totalItems = data.length;
                                var itemsPerPage = 7;
                                var totalPages = Math.ceil(totalItems / itemsPerPage);

                                // Get the table body element
                                var tableBody = document.querySelector("#cowTablebody");
                                var paginationLinks = document.getElementById('pagination');
                                paginationLinks.innerHTML = '';

                                var existingRows = tableBody.querySelectorAll(".cow-record");
                                existingRows.forEach((row) => {
                                    row.remove();
                                });

                                data.forEach((record, index) => {
                                    var row = tableBody.insertRow();
                                    row.className = "cow-record";

                                    var cell0 = row.insertCell();
                                    var cell1 = row.insertCell();
                                    var cell2 = row.insertCell();
                                    var cell3 = row.insertCell();
                                    var cell4 = row.insertCell();

                                    cell0.textContent = index + 1;
                                    cell1.textContent = record.cowid;
                                    cell2.textContent = record.date;
                                    cell3.textContent = record.milkamount;
                                    cell4.textContent = record.times;
                                });

                            },
                            error: (message) => {
                                console.log("uffffff");
                                //var Msg = JSON.parse(message);
                                //msg.innerText = "Breed already exist!";
                            }
                        });
                    }


                    $(document).ready(() => {
                        $("#applyFilter").on("click", event => {
                            Filter_records(event);
                        })
                    });

                </script>
            </div>

        </div>

    </div>

    <!-- weekly report -->

    <div id="page2" class="weeklyReports reportCards">
        <div class="duration">Weekly Reports</div>

        <div>
            <canvas id="cowweeklychart"></canvas>
        </div>
        <script>
            var labels = <?php echo json_encode($cows); ?>;
            var milk = <?php echo json_encode($milk); ?>;

            // Create the chart
            var ctx = document.getElementById('cowweeklychart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Milk (L)',
                            data: milk,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            pointRadius: 3,
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                            pointBorderColor: 'rgba(75, 192, 192, 1)',
                            pointHoverRadius: 5,
                            tension: 0.4,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value, index, values) {
                                    return value;
                                },
                            },
                            grid: {
                                drawOnChartArea: true,
                            },
                        },
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Weekly Production by Cows',
                            font: {
                                size: 18,
                                weight: 'bold',
                            },
                        },
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                font: {
                                    size: 14,
                                },
                            },
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeInOutQuart',
                        },
                    },
                },
            });
        </script>
    </div>

    <!-- monthly reports -->

    <div id="page3" class="monthlyReports reportCards">
        <div class="duration">Monthly Reports</div>
        <div class="dailyMilkTable reportTable">
            <table>
                <thead>

                    <th>Month</th>
                    <th>Milk (L)</th>
                    <th>Expense</th>
                    <th>Profit</th>
                </thead>
                <tbody>
                    <?php
                    $months = array(
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'
                    );
                    $months2 = array(
                        'Jan',
                        'Feb',
                        'Mar',
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep',
                        'Oct',
                        'Nov',
                        'Dec'
                    );
                    for ($j = 0; $j < 12; $j++) {
                        $found = false;
                        foreach ($monthlyRecords as $record) {
                            if ($record["month"] == $j + 1) {
                                $found = true;
                                ?>
                                <tr>

                                    <td><?= $months[$j] ?></td>
                                    <td><?= $record["total_milk"] ?></td>
                                    <td><?= $record["total_expense"] ?></td>
                                    <td><?= $record["total_profit"] ?></td>
                                </tr>
                                <?php
                                break;
                            }
                        }
                        if (!$found) {
                            ?>
                    <tr>

                        <td><?= $months[$j] ?></td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                    </tr>
                    <?php
                        }
                    }
                    ?>


                </tbody>
            </table>

            <div class="chart">
                <canvas id="monthlyChart"></canvas>
            </div>

            <script>
                var labels = <?php echo json_encode($months2); ?>;
                var chartData = <?php echo json_encode($monthlyMilk); ?>;
                var expenseReport = <?php echo json_encode($monthlyExpense); ?>;
                var profit = <?php echo json_encode($monthlyProfit); ?>;

                var ctx = document.getElementById('monthlyChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Milk (Liters)',
                                data: chartData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                pointRadius: 3,
                                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                                pointBorderColor: 'rgba(54, 162, 235, 1)',
                                pointHoverRadius: 5,
                                tension: 0.4,
                            },
                            {
                                label: 'Expenses (Rs)',
                                data: expenseReport,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 2,
                                pointRadius: 3,
                                pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                                pointBorderColor: 'rgba(255, 99, 132, 1)',
                                pointHoverRadius: 5,
                                tension: 0.4,
                            },
                            {
                                label: 'Profit (Rs)',
                                data: profit,
                                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                pointRadius: 3,
                                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                                pointBorderColor: 'rgba(75, 192, 192, 1)',
                                pointHoverRadius: 5,
                                tension: 0.4,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                },
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value, index, values) {
                                        if (profit[index] === Math.max(...profit)) {
                                            return value + ' (High)';
                                        } else {
                                            return value;
                                        }
                                    },
                                },
                                grid: {
                                    drawOnChartArea: true,
                                },
                            },
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Monthly record chart',
                                font: {
                                    size: 18,
                                },
                            },
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                },
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart',
                            },
                        },

                    },
                });




            </script>

        </div>
    </div>
</main>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        // Get the active page from localStorage, or default to 'page1'
        const activePage = localStorage.getItem('activePage') || 'page1';

        // Hide all report pages initially
        const reportPages = document.querySelectorAll('.reportCards');
        reportPages.forEach(page => {
            page.style.display = 'none';
        });

        // Show the active page
        const activePageElement = document.getElementById(activePage);
        if (activePageElement) {
            activePageElement.style.display = 'block';

        }

        // Handle link clicks
        const reportLinks = document.querySelectorAll('.reportLinks a');
        reportLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                // Remove 'click' class from all links
                reportLinks.forEach(link => {
                    link.classList.remove('click');
                });

                // Add 'click' class to the clicked link
                link.classList.add('click');

                const targetPage = link.getAttribute('href').substring(1);
                const targetPageElement = document.getElementById(targetPage);

                if (targetPageElement) {
                    // Hide all report pages
                    reportPages.forEach(page => {
                        page.style.display = 'none';
                    });

                    // Show the target page
                    targetPageElement.style.display = 'block';

                    // Store the active page in localStorage
                    localStorage.setItem('activePage', targetPage);
                }
            });
            if (link.getAttribute('href') === '#' + activePage) {
                link.classList.add('click');
            }
        });
    });
</script>