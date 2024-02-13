<main>
    <div class="titles">Milk and Expense Records</div>


    <?php if (isset($_SESSION['msg'])) {
        $msg = $_SESSION['msg'];
        $type = $_SESSION['type'];
        unset($_SESSION['msg']);
        unset($_SESSION['type']); ?>
        <script>
            var msg = '<?php echo $msg; ?>';
            var type = '<?php echo $type; ?>';
            showToast(msg, type); 
        </script> <?php

    } ?>

    <div class="woo">
        <form id="addmilkform" method="POST">
            <div class="header">
                <div>
                    <label for="milkDate">Select Date : </label>
                    <input type="date" name="milkDate" required>
                </div>
                <div>
                    <label class="milkPrice" for="price">Price : </label>
                    <input class="price" type="number" name="milkPrice" placeholder="Enter price" required>
                </div>
                <div>
                    <label class="expenseL" for="price">Expense : </label>
                    <input class="expense" type="number" name="expense" placeholder="Enter expense">
                </div>
            </div>
            <table id="addmilktable">
                <thead>
                    <tr>
                        <td>No.</td>
                        <td>Cow Id</td>
                        <td>Milk Amount (ltr)</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < sizeof($cows); $i++) { ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $cows[$i] ?></td>
                            <td><input type="number" name="<?= $cows[$i] ?>" placeholder="Enter milk quantity"></td>
                        </tr>

                        <?php
                    }

                    ?>
                </tbody>
            </table>


            <input class="button-primary" type="submit" id="addRecord" name="addRecord" value="Add">

        </form>
    </div>
</main>

<script>
    function showNotification(message, duration) {

        console.log(message);
        var notificationContainer = document.getElementById("notificationContainer");

        var notification = document.createElement("div");
        notification.className = "notification";
        notification.textContent = message;

        notificationContainer.appendChild(notification);

        notification.classList.add("show");

        setTimeout(function () {

            notification.classList.remove("show");
            notification.classList.add("hide");
        }, duration - 1000);

        setTimeout(function () {
            notificationContainer.removeChild(notification);
        }, duration);
    }
</script>