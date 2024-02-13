<main>
    <div class="titles">Admin Profile</div>

    <div class="profileS">
        <div class="l">
            <img src=<?php echo $dots . './components/profiles/admin.jpg' ?> alt="img">
            <div><?= $_SESSION['user']->fullname ?></div>

        </div>
        <div class="r">
            <div>Email: <?= $_SESSION['user']->email ?></div>
            <div>Gender: <?= $_SESSION['user']->gender ?></div>
            <div>Address: <?= $_SESSION['user']->address ?></div>
            <div>Contact: <?= $_SESSION['user']->contact ?></div>
        </div>
    </div>
</main>