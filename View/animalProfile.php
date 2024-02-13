<main>
    
    <div class="titles">Animal Profile</div>


    <button onclick="Delete('<?php echo $animalInfo->id; ?>')" class="general-btn" id="profileEditButton">Delete</button>
    <button onclick="edit()" class="general-btn" id="profileEditButton">Edit</button>

    <div class="updatemsg">
    <?php
        if (isset($_SESSION['msg'])) {
            $msg = $_SESSION['msg'];
            $type = $_SESSION['type'];
            unset($_SESSION['msg']);
            unset($_SESSION['type']); ?>
            <script>
                var msg = '<?php echo $msg; ?>';
                var type = '<?php echo $type; ?>';
                showToast(msg, type); 
            </script> <?php
    
        }
        ?>
    </div>


    <form actaction="/update" id="profileForm" method="POST">

        <div class="headinside">General Information</div>
        <div></div>

        <div class="formitem">
            <label for="id">Animal ID :</label>
            <input type="text" name="id" value="<?= $animalInfo->id ?>" id="id" class="id" placeholder="Enter animal id"
                required readonly>
        </div>

        <div class="formitem">
            <label for="breed">Breed :</label>
            <select name="breed" id="breed" required disabled>
                <option value="">Select breed</option>
                <?php
                for ($i = 0; $i < sizeof($breeds); $i++) {
                    ?> <option value="<?= $breeds[$i] ?>" <?php if ($breeds[$i] == $animalInfo->breed)
                           echo 'selected' ?>>
                    <?php echo $breeds[$i] ?></option> <?php
                }
                ?>
            </select>
        </div>

        <div class="formitem">
            <label for="gender">Gender :</label>
            <select name="gender" id="gender" required disabled>
                <option value="">Select animal type</option>
                <option value="Cow" <?php if ($animalInfo->gender == 'Cow')
                    echo 'selected' ?>>Cow</option>
                    <option value="Bull" <?php if ($animalInfo->gender == 'Bull')
                    echo 'selected' ?>>Bull</option>
                </select>
            </div>

            <div class="formitem">
                <label for="color">Color :</label>
                <input type="text" name="color" value="<?php if ($animalInfo->color)
                    echo $animalInfo->color;
                else
                    echo null; ?>" id="color" class="color" placeholder="N/A" readonly>
        </div>

        <div class="formitem">
            <label for="dob">Date of Birth :</label>
            <input type="date" name="dob" value="<?php if ($animalInfo->dob == date('0001-01-01'))
                echo null;
            else
                echo $animalInfo->dob; ?>" id="dob" class="dob" placeholder="Select date of birth" readonly>
        </div>

        <div class="formitem">
            <label for="price">Price :</label>
            <input type="number" name="price" value="<?php if ($animalInfo->price == -1)
                echo null;
            else
                echo $animalInfo->price; ?>" id="price" class="price" placeholder="N/A" readonly>
        </div>

        <!-- 2nd part -->
        <?php
        if ($animalInfo->gender == 'Cow') { ?>
            <div class="headinside">Insemination Details</div>
            <div></div>
            <div class="formitem">
                <label for="insemination">Type :</label>
                <select name="insemination" id="insemination" disabled>
                    <option value="">Select insemination type</option>
                    <option value="Natural Insemination" <?php if ($animalInfo->insemination == 'Natural Insemination')
                        echo 'selected' ?>>Natural Insemination</option>
                        <option value="Artificial Insemination" <?php if ($animalInfo->insemination == 'Artificial Insemination')
                        echo 'selected' ?>>Artificial Insemination</option>
                    </select>
                </div>
                <div class="formitem">
                    <label for="bid">Bull ID :</label>
                    <input type="text" name="bid" value="<?= $animalInfo->bullid ?>" id="bid" class="bid" placeholder="N/A"
                    readonly>
            </div>
            <div class="formitem">
                <label for="date">Date :</label>
                <input type="date" name="date" value="<?php if ($animalInfo->insdate == date('0001-01-01'))
                    echo null;
                else
                    echo $animalInfo->insdate; ?>" id="date" class="date" readonly>
            </div>
            <div></div>
            <!-- 3rd part -->
            <div class="headinside">Pregnancy Details</div>
            <div></div>

            <div class="formitem">
                <label for="pregnant">Pregnant :</label>
                <select name="pregnant" id="pregnant" disabled>
                    <option value="">Select pregnancy status</option>
                    <option value="Yes" <?php if ($animalInfo->pregnant == 'Yes')
                        echo 'selected' ?>>Yes</option>
                        <option value="No" <?php if ($animalInfo->pregnant == 'No')
                        echo 'selected' ?>>No</option>
                    </select>
                </div>
                <div class="formitem">
                    <label for="startDate">From :</label>
                    <input type="date" name="startDate" value="<?php if ($animalInfo->startdate == date('0001-01-01'))
                        echo null;
                    else
                        echo $animalInfo->startdate; ?>" id="startDate" class="startDate" readonly>
            </div>

            <div class="formitem">
                <label for="deliverydate">Delivery :</label>
                <input type="date" name="deliverydate" value="<?php if ($animalInfo->deliverydate == date('0001-01-01'))
                    echo null;
                else
                    echo $animalInfo->deliverydate; ?>" id="deliverydate" class="deliverydate" readonly>
            </div>

            <div class="formitem">
                <label for="abortiondate">Abortion :</label>
                <input type="date" name="abortiondate" value="<?php if ($animalInfo->abortiondate == date('0001-01-01'))
                    echo null;
                else
                    echo $animalInfo->abortiondate; ?>" id="abortiondate" class="abortiondate" readonly>
            </div>
        <?php } ?>
        <button name="updatebtn" class="general-btn" id="general-btn">Update</button>

    </form>
    <?php
    if ($animalInfo->gender == 'Cow') { ?>

        <div class="profileChartHolder">
            <div class="profileChart">
                <canvas id="cowPerformanceChart"></canvas>
            </div>
        </div> <?php }


    if ($response["code"] == true) {
        $performanceRecord = $response["data"];
        for ($i = 0; $i < sizeof($performanceRecord); $i++) {
            $milkData[] = $performanceRecord[$i]["milkamount"];
        }
        $size = sizeof($performanceRecord);
    } else {
        $size = 0;
    }

    ?>



    <script>
        var labels = <?php echo json_encode($labels); ?>;
        var chartData = <?php echo json_encode($milkData); ?>;
        var ctx = document.getElementById('cowPerformanceChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Milk (Liters)',
                    data: chartData,
                    backgroundColor: 'blue',
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Last Seven Days' Milk Records",
                        font: {
                            size: 15,
                            style: 'italic',
                            weight: 'bold'
                        },
                        align: 'end'
                    },
                    legend: {
                        labels: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
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
                        ticks: {
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

<script>
    
  function Delete(id)
  {
    console.log(id);
    var result = confirm("Are you sure?");
    if (result)
    {
        window.location.href = "./deleteAnimal?animal=" + id;
    }
    else
    {
        showToast("As you wish!", "success");
    }
  }

</script>