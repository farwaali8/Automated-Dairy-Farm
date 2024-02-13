<?php 
    $size = count(explode("/", $_SERVER["REQUEST_URI"])) - 2;
    $dots = "./";
    for ($i = 1; $i < $size; $i++)
    {
        if ($i == 1) $dots = "../";
        else $dots .= "../";
    }
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href=<?php echo $dots.'components/style.css' ?>>
    <link rel="stylesheet" href=<?php echo $dots.'components/style2.css' ?>>
    <link rel="stylesheet" href=<?php echo $dots.'components/style3.css' ?>>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="https://kit.fontawesome.com/c5bb0b5d66.js" crossorigin="anonymous"></script>
    
    <style>
        #toastBox {
            position: fixed;
            z-index: 9999;
            bottom: 30px;
            right: 30px;
            display: flex;
            align-items: flex-end;
            flex-direction: column;
            overflow: hidden;
            padding: 20px;
        }

        .toast {
            width: 400px;
            height: 80px;
            background: #fff;
            font-weight: 500;
            margin: 15px 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            position: relative;
            transform: translateX(100%);
            animation: moveleft 0.5s linear forwards;
            color: black;
        }

        @keyframes moveleft {
            100% {
                transform: translateX(0);
            }
        }

        .toast i {
            margin: 0 20px;
            font-size: 35px;
            color: green;
        }

        .toast.error i {
            color: red;
        }

        .toast.invalid i {
            color: orange;
        }

        .toast::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: green;
            animation: anim 3s linear forwards;
        }

        .toast.error::after {
            background: red;
        }

        .toast.invalid::after {
            background: orange;
        }

        @keyframes anim {
            100% {
                width: 0;
            }
        }
    </style>

</head>
<body>
  <div class="container">
    <div id="toastBox"></div>

<script>
    let toastBox =document.getElementById('toastBox');
    function showToast(msg, type)
    {
        if (type === "success")
        {
            var message = '<i class="fa-sharp fa-solid fa-circle-check"></i>' + msg;
        }

        if (type === "error")
        {
            var message = '<i class="fa-sharp fa-solid fa-circle-xmark"></i>' + msg;
        }

        if (type === "invalid")
        {
            var message = '<i class="fa-sharp fa-solid fa-circle-exclamation"></i>' + msg;
        }
        
        let toast = document.createElement('div');
        toast.classList.add('toast');
        toast.innerHTML = message;
        toastBox.appendChild(toast);

        toast.classList.add(type);

        setTimeout(()=>{
            toast.remove();
        }, 3000);
    }
</script>
    