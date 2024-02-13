<main>
    <?php
    if (isset($_SESSION['Msg'])) {
        $msg = $_SESSION['Msg'];
        $type = $_SESSION['type'];
        unset($_SESSION['Msg']);
        unset($_SESSION['type']); ?>
        <script>
            var msg = '<?php echo $msg; ?>';
            var type = '<?php echo $type; ?>';
            showToast(msg, type); 
        </script> <?php

    }
    ?>
    <div class="titles">All Animals</div>

    <div class="animalTable">

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Animal Id</th>
                    <th>Breed</th>
                    <th>Gender</th>
                    <th>Color</th>
                    <th>Date of Birth</th>
                    <th>Price (PKR)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < sizeof($records); $i++) {
                    ?>

                    <tr onclick="redirectToProfile('<?php echo $records[$i]->id; ?>');">
                        <td><?= $i + 1 ?></td>
                        <td><?= $records[$i]->id ?></td>
                        <td><?= $records[$i]->breed ?></td>
                        <td><?= $records[$i]->gender ?></td>
                        <td><?php if ($records[$i]->color)
                            echo $records[$i]->color;
                        else
                            echo '---' ?></td>
                            <td><?php if ($records[$i]->dob == date('0001-01-01'))
                            echo '---';
                        else
                            echo $records[$i]->dob ?>
                            </td>
                            <td><?php if ($records[$i]->price == -1)
                            echo '---';
                        else
                            echo $records[$i]->price ?></td>
                        </tr>
                        <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</main>