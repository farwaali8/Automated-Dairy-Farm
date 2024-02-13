<main>
<?php  
    if (isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
        
        unset($_SESSION['msg']);
        ?>
        <script>
            var msg = '<?php echo $msg; ?>';
            
            showToast(msg, "success"); 
        </script> <?php

    }
    ?>

    <div class="titles">Health</div>


    <div class="healthChart">
        <canvas id="healthchart"></canvas>
    </div>
 
    <div class="titles">Examination Details</div>
    <div class="ffff">
        <form action="./addExamination" method="post">
            <input type="text" id="id" name="id" placeholder="Enter animal id" required>
            <input type="date" id="date" name="date" required>
            <input type="text" id="disease" name="disease" placeholder="Enter disease" required>
            <input type="text" id="temp" name="temp" placeholder="Enter temperature (&#176;C)" required>
            <input type="text" id="med" name="med" placeholder="Enter medications" required>
            
          
            <input type="submit" value="Add">
        </form>
    </div>

    <div class="titles" id="sickAnimals">Sick Animals</div>
    <div class="sicktable">

        <table>
            <thead>
                <th>Date</th>
                <th>Animal ID</th>
                <th>Disease</th>
                <th>Temperature</th>
                <th>Medications</th>
                <th>Delete</th>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION["Msg"])) {
                    $msg = $_SESSION["Msg"];
                    unset($_SESSION["Msg"]);
                    $type = $_SESSION["type"];
                    unset($_SESSION["type"]);
                } ?>
                <script>
                    var msg = '<?php echo $msg; ?>';
                    var type = '<?php echo $type; ?>';
                    showToast(msg, type);
                </script> <?php

                for ($i = 0; $i < $sickSize; $i++) {
                    ?>
                    <tr>
                        <td><?= $data[$i]["date"] ?></td>
                        <td><?= $data[$i]["id"] ?></td>
                        <td><?= $data[$i]["disease"] ?></td>
                        <td><?= $data[$i]["temperature"] ?>&#176;C</td>
                        <td><?= $data[$i]["medications"] ?></td>
                        <td><button onclick='deleteSick("<?php echo $data[$i]["id"]; ?>")'>Delete</button></td>
                    </tr> <?php
                }
                ?>
            </tbody>
        </table>

    </div>

    <script>

        function deleteSick(id) {
            console.log(id);
            var xx = confirm("Are you sure?");
            var msg = "OH. " + id + " is still SICK!";
            if (xx) {
                console.log("yes");
                window.location.href = "./deleteSick?sickid=" + id;
            }
            else showToast(msg, "error");
        }

        var labels = <?php echo json_encode($labels); ?>;
        var chartData = <?php echo json_encode($chartData); ?>;
        var backgroundColors = ['#D50000', '#2962FF'];
        var ctx = document.getElementById('healthchart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Animals',
                    data: chartData,
                    backgroundColor: backgroundColors,
                }]
            },
            options: {
                responsive: true,
                plugins: {

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

    </script>

</main>