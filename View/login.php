    <div class="container">
        <form id="form" method="POST">
            <h3 style="margin-bottom: .5cm">Login</h3>
           
            <input class="form-control form-group" type="email" id="email" name="email" placeholder="enter email" required>
          
            <input class="form-control form-group" type="password" id="password" name="password" placeholder="enter password" required>
            <strong id="msg"><?php
            if (isset($_SESSION['msg']))
            {
                echo $_SESSION['msg'];unset($_SESSION['msg']);
                
            }
            ?></strong>
            <div class="button">
                <input type="submit" class="form-group" name="login" id="login" value="Login">
            </div>
            
        </form>
    </div>

</body>
</html