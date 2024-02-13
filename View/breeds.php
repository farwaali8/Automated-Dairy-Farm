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

    <div class="titles">Breeds</div>

    <div class="addnewbreed">
        <div>Add new breed</div>
        <form method="post">
            <div class="newbreedgrid">

                <input type="text" placeholder="Enter breed" id="newbreed" name="newbreed" required>
                <button name="addbreedbtn" id="addbreedbtn">Add</button>

            </div>
        </form>
    </div>
    <?php

    for ($i = 0; $i < sizeof($breeds); $i++) { ?>
        <div class="breed">
            <div class="breedTop">
                <div id="<?= $breeds[$i] ?>" class="titles"> <?= $breeds[$i] ?> </div>
                <button class="deletebreedbtn" onclick="deleteBreed('<?php echo $breeds[$i]; ?>');">Delete</button>
            </div>
            <div class="cows">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Animal Id</th>
                            <th>Gender</th>
                            <th>Color</th>
                            <th>Date of Birth</th>
                            <th>Price (PKR)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $count = 0;
                        for ($j = 0; $j < sizeof($records); $j++) {
                            if ($records[$j]->breed == $breeds[$i]) { ?>
                                <tr onclick="redirectToProfile('<?php echo $records[$j]->id; ?>');">
                                    <td><?= $count += 1 ?></td>
                                    <td><?= $records[$j]->id ?></td>
                                    <td><?= $records[$j]->gender ?></td>
                                    <td><?php if ($records[$j]->color)
                                        echo $records[$j]->color;
                                    else
                                        echo '---' ?></td>
                                        <td><?php if ($records[$j]->dob == date('0001-01-01'))
                                        echo '---';
                                    else
                                        echo $records[$j]->dob ?></td>
                                        <td><?php if ($records[$j]->price == -1)
                                        echo '---';
                                    else
                                        echo $records[$j]->price ?></td>
                                    </tr> <?php
                            }
                        }
                        if ($count == 0) { ?>
                        <tr>
                            <td colspan="6">
                                <h2 class="empty">No animals here!</h2>
                            </td>
                        </tr> <?php } ?>
            </div>
            </tbody>

            </table>

        </div> <?php
    }
    ?>

</main>

<script>
    // function Add_breed(event) {

    //     var breed = $("#newbreed").val();
    //     var msg = document.getElementById("addbreedmsg");
    //     if (!breed) {
    //         msg.innerText = "Breed is required!";
    //         return;
    //     }


    //     var formdata = new FormData();
    //     formdata.append("breed", breed);

    //     $.ajax({
    //         url: './addnewbreed',
    //         contentType: false,
    //         processData: false,
    //         data: formdata,
    //         type: "POST",
    //         success: (message) => {
    //             var Msg = JSON.parse(message);
    //             msg.innerText = Msg.message;
    //         },
    //         error: (message) => {
    //             //var Msg = JSON.parse(message);
    //             msg.innerText = "Breed already exist!";
    //         }
    //     });
    // }


    // $(document).ready(() => {
    //     $("#addbreedbtn").on("click", event => {
    //         Add_breed(event);
    //     })
    // });
</script>