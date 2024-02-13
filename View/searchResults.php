<main>
    <div class="searchResults">
        <div class="titles">Search results for : <?= $what ?></div>
    </div>

    <div class="searchTable">
        <table>
            <thead>
                <tr>
                    <td>No.</td>
                    <td><?= $what ?> ID</td>
                    <td>Breed</td>
                    <td>Color</td>
                    <td>Date of birth</td>
                    <td>Price</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = $isAnimal['data'];
                
                for ($i = 0; $i < sizeof($data); $i++) {
                    ?>

                    <tr onclick="redirectToProfile('<?php echo $data[$i]['id']; ?>');">
                        <td><?= $i + 1 ?></td>
                        <td><?= $data[$i]['id'] ?></td>
                        <td><?= $data[$i]['breed'] ?></td>
                        
                        <td><?php if ($data[$i]['color'])
                            echo $data[$i]['color'];
                        else
                            echo '---' ?></td>
                            <td><?php if ($data[$i]['dob'] == date('0001-01-01'))
                            echo '---';
                        else
                            echo $data[$i]['dob'] ?>
                            </td>
                            <td><?php if ($data[$i]['price'] == -1)
                            echo '---';
                        else
                            echo $data[$i]['price'] ?></td>
                        </tr>
                        <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</main>