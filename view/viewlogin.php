<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../design/style.css">
</head>
<style>
    .container{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
    .form-container{
        height: 100%;
        background-color: var(--dark-gray);
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: -5px 0 25px 0 var(--dark-accent);
    }
    .form-container .title{
        margin-bottom: 20px;
    }
    .title h1{
        padding-bottom: 5px;
        border-bottom: 8px solid var(--accent-color);
    }
    @media only screen and (max-width: 900px){
        .logo{
            display: none;
        }
    }
    
</style>
<body>
    <div class="container">
        <div class="row" style="width: 100%; height: 100%;">
            <div class="col-8 logo">
                <h1>sistem spp</h1> 
            </div>
            <div class="col-4 form-container">
                <div class="row">
                    <div class="col-12 title">
                        <h1>login</h1>
                    </div>
                    <div class="col-10 form-wrapper show">
                        <form action="../proses/proses_login.php" class="row" autocomplete="off" method="POST">
                            <div class="form-item col-12">
                                <input type="text" name="username" placeholder=" ">
                                <label for="username">Username</label>
                            </div>
                            <div class="form-item col-12">
                                <input type="password" name="password" placeholder=" ">
                                <label for="password">Password</label>
                            </div>
                            <div class="button-wrap col-12">
                                <input type="submit" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>